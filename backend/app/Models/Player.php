<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'first_name',
        'last_name',
        'display_name',
        'slug',
        'birth_date',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function playerSeasonRegistrations(): HasMany
    {
        return $this->hasMany(PlayerSeasonRegistration::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(PlayerRole::class)->withPivot('is_primary')->withTimestamps();
    }

    public function primaryRole(): BelongsToMany
    {
        return $this->roles()->wherePivot('is_primary', true);
    }
}
