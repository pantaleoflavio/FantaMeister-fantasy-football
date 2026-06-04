<?php

namespace Database\Factories;

use App\Models\Matchday;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matchday>
 */
class MatchdayFactory extends Factory
{
    protected $model = Matchday::class;

    public function definition(): array
    {
        return [
            'season_id' => Season::factory(),
            'number' => 1,
            'name' => 'Matchday 1',
            'starts_at' => now(),
            'ends_at' => now()->addDay(),
            'status' => 'scheduled',
        ];
    }
}
