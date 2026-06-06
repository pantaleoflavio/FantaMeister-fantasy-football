<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMatchdayScoreDetail extends Model
{
    protected $fillable = [
        'team_matchday_score_id',
        'player_id',
        'player_score_id',
        'replaced_player_id',
        'points',
        'was_starter',
        'was_bench',
        'was_used_as_substitute',
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'was_starter' => 'boolean',
        'was_bench' => 'boolean',
        'was_used_as_substitute' => 'boolean',
    ];

    public function teamMatchdayScore(): BelongsTo
    {
        return $this->belongsTo(TeamMatchdayScore::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function playerScore(): BelongsTo
    {
        return $this->belongsTo(PlayerScore::class);
    }

    public function replacedPlayer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'replaced_player_id');
    }
}
