<?php

namespace App\Models;

use App\Models\FantasyTeam;
use App\Models\Player;
use App\Models\TradeProposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeProposalItem extends Model
{
    protected $fillable = [
        'trade_proposal_id',
        'fantasy_team_id',
        'player_id',
    ];

    public function tradeProposal(): BelongsTo
    {
        return $this->belongsTo(TradeProposal::class);
    }

    public function fantasyTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
