<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\LeagueSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeagueSetting>
 */
class LeagueSettingFactory extends Factory
{
    protected $model = LeagueSetting::class;

    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'key' => $this->faker->unique()->slug(2),
            'value' => ['enabled' => true],
        ];
    }
}
