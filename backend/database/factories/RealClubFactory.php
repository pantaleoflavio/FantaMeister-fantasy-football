<?php

namespace Database\Factories;

use App\Models\RealClub;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RealClub>
 */
class RealClubFactory extends Factory
{
    protected $model = RealClub::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->city().' FC';

        return [
            'name' => $name,
            'short_name' => substr($name, 0, 3),
            'slug' => $this->faker->unique()->slug(),
            'country_code' => $this->faker->optional()->countryCode(),
            'logo_path' => null,
        ];
    }
}
