<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
