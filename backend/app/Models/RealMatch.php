<?php

namespace App\Models;

use App\Models\Matchday;
use App\Models\RealClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealMatch extends Model
{
     use HasFactory;
     
    protected $fillable = [
        'matchday_id',
        'home_club_id',
        'away_club_id',
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

    public function homeClub(): BelongsTo
    {
        return $this->belongsTo(RealClub::class, 'home_club_id');
    }

    public function awayClub(): BelongsTo
    {
        return $this->belongsTo(RealClub::class, 'away_club_id');
    }
}
