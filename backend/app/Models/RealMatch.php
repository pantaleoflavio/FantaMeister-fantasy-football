<?php

namespace App\Models;

use App\Enums\RealMatchStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

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
        'status' => RealMatchStatus::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $match): void {
            $matchdaySeasonId = Matchday::query()->find($match->matchday_id)?->season_id;
            $clubSeasonIds = SeasonClub::query()->whereKey([$match->home_season_club_id, $match->away_season_club_id])->pluck('season_id', 'id');

            if (
                $match->home_season_club_id === $match->away_season_club_id
                || $clubSeasonIds->count() !== 2
                || $clubSeasonIds->contains(fn ($seasonId) => $seasonId !== $matchdaySeasonId)
            ) {
                throw ValidationException::withMessages(['season_clubs' => 'Home and away clubs must be different and belong to the matchday season.']);
            }
        });
    }

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
