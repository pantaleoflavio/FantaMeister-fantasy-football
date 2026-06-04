<?php

namespace Tests\Feature;

use App\Models\FantasyTeam;
use App\Models\Formation;
use App\Models\FormationModule;
use App\Models\Import;
use App\Models\ImportRowError;
use App\Models\League;
use App\Models\LeagueRole;
use App\Models\LeagueSetting;
use App\Models\LeagueStatus;
use App\Models\LeagueType;
use App\Models\Player;
use App\Models\PlayerRole;
use App\Models\Standing;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_lookup_seeders_create_required_values(): void
    {
        $this->seed();

        $this->assertSame(
            ['defender', 'forward', 'goalkeeper', 'midfielder'],
            PlayerRole::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['active', 'archived', 'completed', 'draft', 'setup'],
            LeagueStatus::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['classic', 'formula_one', 'head_to_head'],
            LeagueType::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['co_commissioner', 'commissioner', 'participant'],
            LeagueRole::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertCount(7, FormationModule::all());
    }

    public function test_player_can_have_multiple_roles_and_primary_role(): void
    {
        $this->seed();

        $player = Player::factory()->create();
        $goalkeeper = PlayerRole::where('key', 'goalkeeper')->firstOrFail();
        $defender = PlayerRole::where('key', 'defender')->firstOrFail();

        $player->roles()->attach($goalkeeper->id, ['is_primary' => true]);
        $player->roles()->attach($defender->id, ['is_primary' => false]);

        $this->assertCount(2, $player->fresh()->roles);
        $this->assertTrue(
            (bool) $player->roles()->where('player_role_id', $goalkeeper->id)->first()->pivot->is_primary,
        );
    }

    public function test_league_relationship_and_membership(): void
    {
        $this->seed();

        $commissioner = User::factory()->create();
        $league = League::factory()->create(['commissioner_user_id' => $commissioner->id]);
        $member = User::factory()->create();
        $participantRole = LeagueRole::where('key', 'participant')->firstOrFail();

        $league->users()->attach($member->id, [
            'league_role_id' => $participantRole->id,
            'joined_at' => now(),
        ]);

        $this->assertNotNull($league->season);
        $this->assertNotNull($league->type);
        $this->assertNotNull($league->status);
        $this->assertEquals($commissioner->id, $league->commissioner->id);
        $this->assertCount(1, $league->fresh()->users);
    }

    public function test_fantasy_team_is_unique_per_league_and_user(): void
    {
        $team = FantasyTeam::factory()->create();

        $this->expectException(QueryException::class);

        FantasyTeam::factory()->create([
            'league_id' => $team->league_id,
            'user_id' => $team->user_id,
        ]);
    }

    public function test_seeded_433_has_correct_requirements(): void
    {
        $this->seed();

        $module = FormationModule::where('name', '4-3-3')->firstOrFail();
        $requirements = $module->requirements()
            ->with('playerRole')
            ->get()
            ->mapWithKeys(fn($requirement) => [
                $requirement->playerRole->key => $requirement->required_count,
            ])
            ->all();

        $this->assertSame([
            'goalkeeper' => 1,
            'defender' => 4,
            'midfielder' => 3,
            'forward' => 3,
        ], $requirements);
    }

    public function test_jsonb_fields_store_structures(): void
    {
        $this->seed();

        $league = League::factory()->create();
        $team = FantasyTeam::factory()->create(['league_id' => $league->id]);

        $setting = LeagueSetting::create([
            'league_id' => $league->id,
            'key' => 'rules',
            'value' => ['a' => [1, 2]],
        ]);
        $formation = Formation::factory()->create([
            'league_id' => $league->id,
            'fantasy_team_id' => $team->id,
            'snapshot' => ['captain' => 'x'],
        ]);
        $standing = Standing::create([
            'league_id' => $league->id,
            'fantasy_team_id' => $team->id,
            'metadata' => ['tie_break' => 'gf'],
        ]);
        $import = Import::create([
            'type' => 'players',
            'filename' => 'x.csv',
            'disk' => 'local',
            'path' => 'imports/x.csv',
            'status' => 'completed',
        ]);
        $rowError = ImportRowError::create([
            'import_id' => $import->id,
            'row_number' => 2,
            'row_data' => ['field' => 'bad'],
            'error_message' => 'invalid',
        ]);

        $this->assertSame(['a' => [1, 2]], $setting->fresh()->value);
        $this->assertSame(['captain' => 'x'], $formation->fresh()->snapshot);
        $this->assertSame(['tie_break' => 'gf'], $standing->fresh()->metadata);
        $this->assertSame(['field' => 'bad'], $rowError->fresh()->row_data);
    }
}
