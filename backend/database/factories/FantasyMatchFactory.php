<?php

namespace Database\Factories;

use App\Models\FantasyMatch;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\Matchday;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FantasyMatch>
 */
class FantasyMatchFactory extends Factory
{
    protected $model = FantasyMatch::class;

    public function definition(): array
    {
        $league = League::factory()->create();

        return [
            'league_id' => $league->id,
            'matchday_id' => Matchday::factory()->create(['season_id' => $league->season_id])->id,
            'home_fantasy_team_id' => FantasyTeam::factory()->create(['league_id' => $league->id])->id,
            'away_fantasy_team_id' => FantasyTeam::factory()->create(['league_id' => $league->id])->id,
        ];
    }
}
