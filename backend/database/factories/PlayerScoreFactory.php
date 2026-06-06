<?php

namespace Database\Factories;

use App\Models\Matchday;
use App\Models\Player;
use App\Models\PlayerScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerScore>
 */
class PlayerScoreFactory extends Factory
{
    protected $model = PlayerScore::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'matchday_id' => Matchday::factory(),
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
