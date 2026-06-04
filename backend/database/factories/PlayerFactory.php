<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\RealClub;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'real_club_id' => RealClub::factory(),
            'external_id' => $this->faker->uuid(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'display_name' => "$firstName $lastName",
            'slug' => $this->faker->unique()->slug(),
            'birth_date' => $this->faker->date(),
            'quotation' => 100.00,
            'is_active' => true,
        ];
    }
}
