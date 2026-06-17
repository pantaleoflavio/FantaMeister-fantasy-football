<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\FantasyTeamPlayer;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FantasyTeamPlayer>
 */
class FantasyTeamPlayerFactory extends Factory
{
    protected $model = FantasyTeamPlayer::class;

    public function definition(): array
    {
        $fantasyTeam = FantasyTeam::factory()->create();

        return [
            'league_id' => $fantasyTeam->league_id,
            'fantasy_team_id' => $fantasyTeam->id,
            'player_id' => Player::factory(),
            'assigned_by_user_id' => User::factory(),
            'purchase_price' => 100.00,
            'assigned_at' => now(),
            'released_at' => null,
        ];
    }
}
