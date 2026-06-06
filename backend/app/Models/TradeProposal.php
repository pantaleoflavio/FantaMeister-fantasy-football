<?php

namespace App\Models;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\TradeProposalItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TradeProposal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'league_id',
        'from_team_id',
        'to_team_id',
        'cash_paid_by_team_id',
        'cash_amount',
        'status',
        'message',
        'expires_at',
    ];

    protected $casts = [
        'cash_amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function fromTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class, 'from_team_id');
    }

    public function toTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class, 'to_team_id');
    }

    public function cashPaidByTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class, 'cash_paid_by_team_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TradeProposalItem::class);
    }
}
