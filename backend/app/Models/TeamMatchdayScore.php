<?php

namespace App\Models;

use App\Models\FantasyTeam;
use App\Models\Formation;
use App\Models\League;
use App\Models\Matchday;
use App\Models\TeamMatchdayScoreDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMatchdayScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'fantasy_team_id',
        'matchday_id',
        'formation_id',
        'points',
        'base_points',
        'substitution_points',
        'defense_modifier_points',
        'goalkeeper_clean_sheet_bonus_points',
        'status',
        'calculated_at',
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'base_points' => 'decimal:2',
        'substitution_points' => 'decimal:2',
        'defense_modifier_points' => 'decimal:2',
        'goalkeeper_clean_sheet_bonus_points' => 'decimal:2',
        'calculated_at' => 'datetime',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function fantasyTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class);
    }

    public function matchday(): BelongsTo
    {
        return $this->belongsTo(Matchday::class);
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TeamMatchdayScoreDetail::class);
    }
}
