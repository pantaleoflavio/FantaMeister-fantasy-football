<?php

namespace App\Models;

use App\Models\FantasyTeam;
use App\Models\League;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'fantasy_team_id',
        'points_total',
        'fantasy_points_total',
        'played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'position',
        'metadata',
    ];

    protected $casts = [
        'fantasy_points_total' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function fantasyTeam(): BelongsTo
    {
        return $this->belongsTo(FantasyTeam::class);
    }
}
