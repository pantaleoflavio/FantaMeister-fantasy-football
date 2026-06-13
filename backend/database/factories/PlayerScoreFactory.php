<?php

namespace Database\Factories;

use App\Models\Matchday;
use App\Models\PlayerScore;
use App\Models\PlayerSeasonRegistration;
use App\Models\SeasonClub;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PlayerScore> */
class PlayerScoreFactory extends Factory
{
    protected $model = PlayerScore::class;

    public function definition(): array
    {
        $matchday = Matchday::factory()->create();

        return [
            'player_season_registration_id' => PlayerSeasonRegistration::factory()->create([
                'season_club_id' => SeasonClub::factory()->create(['season_id' => $matchday->season_id])->id,
            ])->id,
            'matchday_id' => $matchday->id,
            'base_rating' => 6.00,
            'goals' => 0,
            'assists' => 0,
            'yellow_cards' => 0,
            'red_cards' => 0,
            'own_goals' => 0,
            'penalties_scored' => 0,
            'penalties_missed' => 0,
            'penalties_saved' => 0,
            'goals_conceded' => 0,
            'clean_sheet' => false,
            'final_score' => 6.00,
            'status' => 'confirmed',
        ];
    }
}
