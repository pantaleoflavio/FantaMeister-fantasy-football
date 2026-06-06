<?php

namespace Database\Factories;

use App\Models\FantasyMatch;
use App\Models\FantasyMatchResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FantasyMatchResult>
 */
class FantasyMatchResultFactory extends Factory
{
    protected $model = FantasyMatchResult::class;

    public function definition(): array
    {
        return [
            'fantasy_match_id' => FantasyMatch::factory(),
            'home_points' => 0,
            'away_points' => 0,
            'home_goals' => 0,
            'away_goals' => 0,
            'result_status' => 'pending',
            'calculated_at' => null,
        ];
    }
}
