<?php

namespace Database\Factories;

use App\Models\RealCompetition;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Season>
 */
class SeasonFactory extends Factory
{
    protected $model = Season::class;

    public function definition(): array
    {
        return [
            'real_competition_id' => RealCompetition::factory(),
            'name' => $this->faker->unique()->year().'/'.$this->faker->year(),
            'starts_at' => now()->startOfYear(),
            'ends_at' => now()->endOfYear(),
            'is_active' => true,
        ];
    }
}
