<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FantasyTeam>
 */
class FantasyTeamFactory extends Factory
{
    protected $model = FantasyTeam::class;

    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'user_id' => User::factory(),
            'name' => $this->faker->company(),
            'slug' => $this->faker->unique()->slug(),
            'logo_path' => null,
            'budget' => 500.00,
            'remaining_budget' => 500.00,
        ];
    }
}
