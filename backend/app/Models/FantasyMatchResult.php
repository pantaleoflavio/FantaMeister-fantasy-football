<?php

namespace App\Models;

use App\Models\FantasyMatch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FantasyMatchResult extends Model
{
    protected $fillable = [
        'fantasy_match_id',
        'home_points',
        'away_points',
        'home_goals',
        'away_goals',
        'result_status',
        'calculated_at',
    ];

    protected $casts = [
        'home_points' => 'decimal:2',
        'away_points' => 'decimal:2',
        'calculated_at' => 'datetime',
    ];

    public function fantasyMatch(): BelongsTo
    {
        return $this->belongsTo(FantasyMatch::class);
    }
}
