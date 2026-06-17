<?php

namespace Database\Factories;

use App\Enums\CompetitionType;
use App\Models\RealCompetition;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<RealCompetition> */
class RealCompetitionFactory extends Factory
{
    protected $model = RealCompetition::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucwords($name),
            'code' => $this->faker->unique()->slug(2),
            'country_code' => $this->faker->optional()->countryCode(),
            'type' => CompetitionType::DomesticLeague,
            'is_active' => true,
        ];
    }
}
