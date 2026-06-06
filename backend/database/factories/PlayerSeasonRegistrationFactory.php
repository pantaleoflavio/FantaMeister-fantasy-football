<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\PlayerSeasonRegistration;
use App\Models\RealClub;
use App\Models\Season;
use App\Models\SeasonClub;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PlayerSeasonRegistration> */
class PlayerSeasonRegistrationFactory extends Factory
{
    protected $model = PlayerSeasonRegistration::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'season_id' => Season::factory(),
            'real_club_id' => RealClub::factory(),
            'external_id' => $this->faker->optional()->uuid(),
            'shirt_number' => $this->faker->optional()->numberBetween(1, 99),
            'quotation' => $this->faker->randomFloat(2, 1, 100),
            'is_active' => true,
            'registered_at' => now(),
            'released_at' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (PlayerSeasonRegistration $registration) {
            SeasonClub::query()->firstOrCreate([
                'season_id' => $registration->season_id,
                'real_club_id' => $registration->real_club_id,
            ]);
        });
    }
}
