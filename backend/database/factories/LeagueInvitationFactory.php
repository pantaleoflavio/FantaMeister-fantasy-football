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
            'token' => $this->faker->unique()->sha256(),
            'status' => 'active',
            'max_uses' => 1,
            'used_count' => 0,
            'expires_at' => now()->addWeek(),
        ];
    }
}
