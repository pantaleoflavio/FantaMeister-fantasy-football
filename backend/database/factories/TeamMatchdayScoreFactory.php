<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\Formation;
use App\Models\Matchday;
use App\Models\TeamMatchdayScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMatchdayScore>
 */
class TeamMatchdayScoreFactory extends Factory
{
    protected $model = TeamMatchdayScore::class;

    public function definition(): array
    {
        $formation = Formation::factory()->create();
        $fantasyTeam = FantasyTeam::query()->findOrFail($formation->fantasy_team_id);
        $matchday = Matchday::query()->findOrFail($formation->matchday_id);

        return [
            'league_id' => $formation->league_id,
            'fantasy_team_id' => $fantasyTeam->id,
            'matchday_id' => $matchday->id,
            'formation_id' => $formation->id,
            'points' => 0,
            'base_points' => 0,
            'substitution_points' => 0,
            'defense_modifier_points' => 0,
            'goalkeeper_clean_sheet_bonus_points' => 0,
            'status' => 'pending',
            'calculated_at' => null,
        ];
    }
}