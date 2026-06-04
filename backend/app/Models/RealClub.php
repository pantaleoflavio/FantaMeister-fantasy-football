<?php

namespace App\Models;

use App\Models\Player;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RealClub extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'name',
        'short_name',
        'slug',
        'logo_path'
    ];
    
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}
