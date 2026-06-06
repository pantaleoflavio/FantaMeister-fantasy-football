<?php

namespace Tests\Feature\Domain;

use App\Models\Player;
use App\Models\PlayerRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerRoleRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_can_have_multiple_roles(): void
    {
        $this->seed();

        $player = Player::factory()->create();
        $goalkeeper = PlayerRole::query()->where('key', 'goalkeeper')->firstOrFail();
        $defender = PlayerRole::query()->where('key', 'defender')->firstOrFail();

        $player->roles()->attach($goalkeeper->id, ['is_primary' => true]);
        $player->roles()->attach($defender->id, ['is_primary' => false]);

        $player->load('roles');

        $this->assertCount(2, $player->roles);
        $this->assertTrue($player->roles->contains($goalkeeper));
        $this->assertTrue($player->roles->contains($defender));
    }

    public function test_player_can_have_one_primary_role(): void
    {
        $this->seed();

        $player = Player::factory()->create();
        $goalkeeper = PlayerRole::query()->where('key', 'goalkeeper')->firstOrFail();
        $defender = PlayerRole::query()->where('key', 'defender')->firstOrFail();

        $player->roles()->attach($goalkeeper->id, ['is_primary' => true]);
        $player->roles()->attach($defender->id, ['is_primary' => false]);

        $this->assertSame(
            [$goalkeeper->id],
            $player->primaryRole()->pluck('player_roles.id')->all(),
        );
    }

     public function test_multiple_primary_roles_are_visible_when_application_code_creates_them(): void
    {
        $this->seed();

        $player = Player::factory()->create();
        $goalkeeper = PlayerRole::query()->where('key', 'goalkeeper')->firstOrFail();
        $defender = PlayerRole::query()->where('key', 'defender')->firstOrFail();

        $player->roles()->attach($goalkeeper->id, ['is_primary' => true]);
        $player->roles()->attach($defender->id, ['is_primary' => true]);

        $this->assertEqualsCanonicalizing(
            [$goalkeeper->id, $defender->id],
            $player->primaryRole()->pluck('player_roles.id')->all(),
        );
    }
}
