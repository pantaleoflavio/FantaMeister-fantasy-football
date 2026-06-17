<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\Standing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Standing>
 */
class StandingFactory extends Factory
{
    protected $model = Standing::class;

    public function definition(): array
    {
        $fantasyTeam = FantasyTeam::factory()->create();

        return [
            'league_id' => $fantasyTeam->league_id,
            'fantasy_team_id' => $fantasyTeam->id,
            'points_total' => 0,
            'fantasy_points_total' => 0,
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'position' => 1,
            'metadata' => [],
        ];
    }
}
