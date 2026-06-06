<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerSeasonRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id', 'season_id', 'real_club_id', 'external_id', 'shirt_number', 'quotation',
        'is_active', 'registered_at', 'released_at',
    ];

    protected $casts = [
        'quotation' => 'decimal:2',
        'is_active' => 'boolean',
        'registered_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function realClub(): BelongsTo
    {
        return $this->belongsTo(RealClub::class);
    }

    public function playerScores(): HasMany
    {
        return $this->hasMany(PlayerScore::class);
    }
}
