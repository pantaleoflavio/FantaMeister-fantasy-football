<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\LeagueInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeagueInvitation>
 */
class LeagueInvitationFactory extends Factory
{
    protected $model = LeagueInvitation::class;

    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'created_by_user_id' => User::factory(),
            'code' => strtoupper($this->faker->unique()->bothify('????##')),
            'status' => 'active',
            'max_uses' => 1,
            'used_count' => 0,
            'expires_at' => now()->addWeek(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(): array => ['status' => 'active']);
    }

    public function cancelled(): static
    {
        return $this->state(fn(): array => ['status' => 'cancelled']);
    }

    public function expired(): static
    {
        return $this->state(fn(): array => ['expires_at' => now()->subDay()]);
    }

    public function exhausted(): static
    {
        return $this->state(fn(): array => ['max_uses' => 1, 'used_count' => 1]);
    }

    public function unlimited(): static
    {
        return $this->state(fn(): array => ['max_uses' => null]);
    }

    public function singleUse(): static
    {
        return $this->state(fn(): array => ['max_uses' => 1, 'used_count' => 0]);
    }
}
