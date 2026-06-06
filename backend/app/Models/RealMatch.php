<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'matchday_id',
        'home_season_club_id',
        'away_season_club_id',
        'kickoff_at',
        'home_score',
        'away_score',
        'status',
    ];

    protected $casts = [
        'kickoff_at' => 'datetime',
    ];

    public function matchday(): BelongsTo
    {
        return $this->belongsTo(Matchday::class);
    }

    public function homeSeasonClub(): BelongsTo
    {
        return $this->belongsTo(SeasonClub::class, 'home_season_club_id');
    }

    public function awaySeasonClub(): BelongsTo
    {
        return $this->belongsTo(SeasonClub::class, 'away_season_club_id');
    }
}
