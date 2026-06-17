<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\TradeProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TradeProposal>
 */
class TradeProposalFactory extends Factory
{
    protected $model = TradeProposal::class;

    public function definition(): array
    {
        $league = League::factory()->create();

        return [
            'league_id' => $league->id,
            'from_team_id' => FantasyTeam::factory()->create(['league_id' => $league->id])->id,
            'to_team_id' => FantasyTeam::factory()->create(['league_id' => $league->id])->id,
            'cash_paid_by_team_id' => null,
            'cash_amount' => 0,
            'status' => 'pending',
            'message' => $this->faker->sentence(),
            'expires_at' => now()->addWeek(),
        ];
    }
}
