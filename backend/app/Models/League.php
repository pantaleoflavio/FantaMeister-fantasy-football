<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'league_type_id',
        'league_status_id',
        'commissioner_user_id',
        'name',
        'slug',
        'description',
        'max_participants',
        'invite_code',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LeagueType::class, 'league_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(LeagueStatus::class, 'league_status_id');
    }

    public function commissioner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commissioner_user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('league_role_id', 'joined_at')->withTimestamps();
    }

    public function fantasyTeams(): HasMany
    {
        return $this->hasMany(FantasyTeam::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(LeagueSetting::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(LeagueInvitation::class);
    }
}
