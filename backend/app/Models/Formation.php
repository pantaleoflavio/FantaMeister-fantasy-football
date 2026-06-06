<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'fantasy_team_id',
        'matchday_id',
        'formation_module_id',
        'source_formation_id',
        'is_confirmed',
        'is_auto_generated',
        'submitted_at',
        'locked_at',
        'snapshot',
    ];

    protected $casts = [
        'is_confirmed' => 'boolean',
        'is_auto_generated' => 'boolean',
        'submitted_at' => 'datetime',
        'locked_at' => 'datetime',
        'snapshot' => 'array',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(FormationPlayer::class);
    }

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

    public function formationModule(): BelongsTo
    {
        return $this->belongsTo(FormationModule::class);
    }

    public function sourceFormation(): BelongsTo
    {
        return $this->belongsTo(self::class, 'source_formation_id');
    }
}
