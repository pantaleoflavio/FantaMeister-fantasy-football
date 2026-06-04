<?php

namespace App\Models;

use App\Models\League;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    protected $fillable = [
        'league_id',
        'fantasy_team_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}