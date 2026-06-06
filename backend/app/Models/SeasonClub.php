<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeasonClub extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id', 'real_club_id', 'display_name', 'external_id', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function realClub(): BelongsTo
    {
        return $this->belongsTo(RealClub::class);
    }

    public function homeRealMatches(): HasMany
    {
        return $this->hasMany(RealMatch::class, 'home_season_club_id');
    }

    public function awayRealMatches(): HasMany
    {
        return $this->hasMany(RealMatch::class, 'away_season_club_id');
    }
}
