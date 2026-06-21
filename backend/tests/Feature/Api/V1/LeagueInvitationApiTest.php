<?php

namespace Tests\Feature\Api\V1;

use App\Enums\LeagueInvitationStatus;
use App\Models\League;
use App\Models\LeagueInvitation;
use App\Models\LeagueMembership;
use App\Models\LeagueRole;
use App\Models\LeagueType;
use App\Models\RealCompetition;
use App\Models\Role;
use App\Models\Season;
use App\Models\User;
use App\Services\LeagueInvitation\InvitationCodeGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LeagueInvitationApiTest extends TestCase
{
    use RefreshDatabase;

    private User $commissioner;

    private League $league;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->commissioner = User::factory()->create();
        $this->league = League::factory()->create([
            'commissioner_user_id' => $this->commissioner->id,
            'season_id' => Season::factory()->create([
                'real_competition_id' => RealCompetition::factory()->create()->id,
            ])->id,
            'league_type_id' => LeagueType::query()->where('key', 'classic')->firstOrFail()->id,
            'max_participants' => 3,
        ]);
        $this->attachMember($this->league, $this->commissioner, 'commissioner');
    }

    public function test_commissioner_can_create_list_and_cancel_invitation(): void
    {
        Sanctum::actingAs($this->commissioner);

        $response = $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", [
            'max_uses' => 2,
            'expires_at' => now()->addDay()->toJSON(),
            'status' => 'cancelled',
            'used_count' => 99,
            'created_by_user_id' => User::factory()->create()->id,
            'league_role_id' => LeagueRole::query()->where('key', 'commissioner')->value('id'),
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors(['status', 'used_count', 'created_by_user_id', 'league_role_id']);

        $create = $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", [
            'max_uses' => 2,
            'expires_at' => now()->addDay()->toJSON(),
        ]);

        $create
            ->assertCreated()
            ->assertJsonPath('data.status', 'active')
            ->assertJsonPath('data.max_uses', 2)
            ->assertJsonPath('data.used_count', 0)
            ->assertJsonPath('data.creator.id', $this->commissioner->id);

        $invitation = LeagueInvitation::query()->firstOrFail();
        $this->assertSame($this->league->id, $invitation->league_id);
        $this->assertSame($this->commissioner->id, $invitation->created_by_user_id);
        $this->assertNotEmpty($invitation->code);

        $this->getJson("/api/v1/leagues/{$this->league->id}/invitations")
            ->assertOk()
            ->assertJsonFragment(['code' => $invitation->code])
            ->assertJsonMissingPath('data.0.creator.email');

        $this->deleteJson("/api/v1/leagues/{$this->league->id}/invitations/{$invitation->id}")->assertNoContent();
        $this->assertSame(LeagueInvitationStatus::Cancelled, $invitation->refresh()->status);
        $this->assertDatabaseHas('league_invitations', ['id' => $invitation->id]);
    }

    public function test_non_commissioners_cannot_manage_invitations(): void
    {
        foreach (['participant', 'co_commissioner'] as $role) {
            $user = User::factory()->create();
            $this->attachMember($this->league, $user, $role);
            Sanctum::actingAs($user);

            $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", [])->assertForbidden();
            $this->getJson("/api/v1/leagues/{$this->league->id}/invitations")->assertForbidden();
        }

        $admin = User::factory()->create();
        $admin->roles()->attach(Role::query()->where('name', 'global_admin')->firstOrFail()->id);
        Sanctum::actingAs($admin);

        $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", [])->assertForbidden();
    }

    public function test_invitation_validation_rejects_invalid_limits_and_expiry(): void
    {
        Sanctum::actingAs($this->commissioner);

        $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", ['max_uses' => 0])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('max_uses');

        $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", ['expires_at' => now()->subDay()->toJSON()])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('expires_at');

        $this->postJson("/api/v1/leagues/{$this->league->id}/invitations", ['max_uses' => 99])
            ->assertUnprocessable();
    }

    public function test_authenticated_user_can_preview_and_accept_valid_invitation(): void
    {
        $invitation = LeagueInvitation::factory()
            ->for($this->league)
            ->create([
                'created_by_user_id' => $this->commissioner->id,
                'max_uses' => 2,
                'used_count' => 0,
            ]);

        $candidate = User::factory()->create();

        Sanctum::actingAs($candidate);

        $this->getJson("/api/v1/league-invitations/{$invitation->code}")
            ->assertOk()
            ->assertJsonPath('data.code', $invitation->code)
            ->assertJsonPath('data.league.id', $this->league->id)
            ->assertJsonPath('data.league.current_member_count', 1)
            ->assertJsonPath('data.current_user_is_member', false);

        $this->postJson("/api/v1/league-invitations/{$invitation->code}/accept")
            ->assertCreated()
            ->assertJsonPath('data.id', $candidate->id)
            ->assertJsonPath('data.role.key', 'participant');

        $participantRole = LeagueRole::query()
            ->where('key', 'participant')
            ->firstOrFail();

        $this->assertDatabaseHas('league_user', [
            'league_id' => $this->league->id,
            'user_id' => $candidate->id,
            'league_role_id' => $participantRole->id,
        ]);

        $membership = LeagueMembership::query()
            ->where('league_id', $this->league->id)
            ->where('user_id', $candidate->id)
            ->firstOrFail();

        $this->assertNotNull($membership->joined_at);
        $this->assertSame(1, $invitation->refresh()->used_count);

        $this->assertDatabaseMissing('fantasy_teams', [
            'league_id' => $this->league->id,
            'user_id' => $candidate->id,
        ]);

        $this->assertSame(0, $candidate->roles()->count());
    }

    public function test_invalid_or_unavailable_invitations_cannot_be_previewed_or_accepted(): void
    {
        $candidate = User::factory()->create();
        Sanctum::actingAs($candidate);

        $this->getJson('/api/v1/league-invitations/UNKNOWN')->assertNotFound();

        foreach ([
            LeagueInvitation::factory()->cancelled()->for($this->league)->create(['created_by_user_id' => $this->commissioner->id]),
            LeagueInvitation::factory()->expired()->for($this->league)->create(['created_by_user_id' => $this->commissioner->id]),
            LeagueInvitation::factory()->exhausted()->for($this->league)->create(['created_by_user_id' => $this->commissioner->id]),
        ] as $invitation) {
            $this->getJson("/api/v1/league-invitations/{$invitation->code}")->assertNotFound();
            $this->postJson("/api/v1/league-invitations/{$invitation->code}/accept")->assertNotFound();
            $this->assertSame($invitation->used_count, $invitation->refresh()->used_count);
        }
    }

    public function test_duplicate_full_and_single_use_acceptance_are_rejected_without_incrementing(): void
    {
        $invitation = LeagueInvitation::factory()
            ->singleUse()
            ->for($this->league)
            ->create([
                'created_by_user_id' => $this->commissioner->id,
            ]);

        $candidate = User::factory()->create();

        Sanctum::actingAs($candidate);

        $this->postJson("/api/v1/league-invitations/{$invitation->code}/accept")
            ->assertCreated();

        $this->postJson("/api/v1/league-invitations/{$invitation->code}/accept")
            ->assertNotFound();

        $this->assertSame(1, $invitation->refresh()->used_count);

        $otherInvitation = LeagueInvitation::factory()
            ->unlimited()
            ->for($this->league)
            ->create([
                'created_by_user_id' => $this->commissioner->id,
            ]);

        $this->postJson("/api/v1/league-invitations/{$otherInvitation->code}/accept")
            ->assertConflict();

        $this->assertSame(0, $otherInvitation->refresh()->used_count);

        $fullLeague = League::factory()->create([
            'max_participants' => 1,
        ]);

        $this->attachMember(
            $fullLeague,
            User::factory()->create(),
            'commissioner'
        );

        $fullInvitation = LeagueInvitation::factory()
            ->unlimited()
            ->for($fullLeague)
            ->create([
                'created_by_user_id' => $fullLeague->commissioner_user_id,
            ]);

        $newUser = User::factory()->create();

        Sanctum::actingAs($newUser);

        $this->postJson("/api/v1/league-invitations/{$fullInvitation->code}/accept")
            ->assertConflict();

        $this->assertSame(0, $fullInvitation->refresh()->used_count);
    }

    public function test_nested_invitation_must_belong_to_route_league(): void
    {
        $otherLeague = League::factory()->create();
        $invitation = LeagueInvitation::factory()->for($otherLeague)->create(['created_by_user_id' => $otherLeague->commissioner_user_id]);
        Sanctum::actingAs($this->commissioner);

        $this->deleteJson("/api/v1/leagues/{$this->league->id}/invitations/{$invitation->id}")->assertNotFound();
    }

    public function test_status_enum_remains_compatible_with_persisted_invitation_statuses(): void
    {
        $invitation = LeagueInvitation::factory()->for($this->league)->create([
            'created_by_user_id' => $this->commissioner->id,
            'status' => LeagueInvitationStatus::Active,
        ]);

        $this->assertTrue($invitation->isAvailable());
        $this->assertSame(LeagueInvitationStatus::Active, $invitation->status);
    }

    public function test_duplicate_code_collision_retries_with_database_constraint_as_guard(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs($this->commissioner);

        $existing = LeagueInvitation::factory()
            ->for($this->league)
            ->create([
                'created_by_user_id' => $this->commissioner->id,
                'code' => 'ABCDEFGHJKLM',
            ]);

        $this->app->instance(
            InvitationCodeGenerator::class,
            new class extends InvitationCodeGenerator
            {
                private array $codes = [
                    'ABCDEFGHJKLM',
                    'HJKLMNPQRSTU',
                ];

                public function generate(): string
                {
                    return array_shift($this->codes)
                        ?? 'HJKLMNPQRSTU';
                }
            }
        );

        $this->postJson(
            "/api/v1/leagues/{$this->league->id}/invitations",
            []
        )
            ->assertCreated()
            ->assertJsonPath('data.code', 'HJKLMNPQRSTU');

        $this->assertDatabaseHas('league_invitations', [
            'code' => $existing->code,
        ]);

        $this->assertDatabaseHas('league_invitations', [
            'code' => 'HJKLMNPQRSTU',
        ]);
    }

    public function test_invitation_create_migration_documents_postgresql_status_and_counter_constraints(): void
    {
        $migration = file_get_contents(database_path('migrations/2026_06_04_123633_create_league_invitations_table.php'));

        $this->assertStringContainsString("status IN ('active', 'cancelled')", $migration);
        $this->assertStringContainsString('used_count >= 0', $migration);
        $this->assertStringContainsString('max_uses IS NULL OR max_uses >= 1', $migration);
        $this->assertStringContainsString('league_invitations_code_unique', $migration);
    }

    public function test_unrelated_unique_violations_are_not_classified_as_code_collisions(): void
    {
        $action = new \App\Services\LeagueInvitation\CreateLeagueInvitationAction(new \App\Services\LeagueInvitation\InvitationCodeGenerator());
        $method = new \ReflectionMethod($action, 'isInvitationCodeUniqueViolation');
        $method->setAccessible(true);
        $exception = new \Illuminate\Database\UniqueConstraintViolationException('pgsql', 'insert', [], new \Exception('duplicate key value violates unique constraint "some_other_unique_constraint"'));

        $this->assertFalse($method->invoke($action, $exception));
    }

    private function attachMember(League $league, User $user, string $role): void
    {
        $league->users()->attach($user->id, [
            'league_role_id' => LeagueRole::query()->where('key', $role)->firstOrFail()->id,
            'joined_at' => now(),
        ]);
    }
}
