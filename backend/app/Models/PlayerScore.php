<?php

namespace App\Models;

use App\Models\Matchday;
use App\Models\Player;
use App\Models\TeamMatchdayScoreDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerScore extends Model
{
     use HasFactory;
     
    protected $fillable = [
        'player_id',
        'matchday_id',
        'base_rating',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards',
        'own_goals',
        'penalties_scored',
        'penalties_missed',
        'penalties_saved',
        'goals_conceded',
        'clean_sheet',
        'final_score',
        'status',
    ];

    protected $casts = [
        'base_rating' => 'decimal:2',
        'clean_sheet' => 'boolean',
        'final_score' => 'decimal:2',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function matchday(): BelongsTo
    {
        return $this->belongsTo(Matchday::class);
    }

    public function teamMatchdayScoreDetails(): HasMany
    {
        return $this->hasMany(TeamMatchdayScoreDetail::class);
    }
}
