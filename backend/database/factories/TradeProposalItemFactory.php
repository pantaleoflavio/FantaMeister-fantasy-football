<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\Player;
use App\Models\TradeProposal;
use App\Models\TradeProposalItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TradeProposalItem>
 */
class TradeProposalItemFactory extends Factory
{
    protected $model = TradeProposalItem::class;

    public function definition(): array
    {
        $tradeProposal = TradeProposal::factory()->create();

        return [
            'trade_proposal_id' => $tradeProposal->id,
            'fantasy_team_id' => FantasyTeam::query()->findOrFail($tradeProposal->from_team_id)->id,
            'player_id' => Player::factory(),
        ];
    }
}