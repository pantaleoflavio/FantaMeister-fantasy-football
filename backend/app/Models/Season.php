<?php

namespace App\Models;

use App\Models\League;
use App\Models\Matchday;
use App\Models\RealClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name','starts_at','ends_at','is_active'
    ];
    
    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean'
    ];

    public function matchdays(): HasMany
    {
        return $this->hasMany(Matchday::class);
    }

    public function realClubs(): HasMany
    {
        return $this->hasMany(RealClub::class);
    }

    public function leagues(): HasMany
    {
        return $this->hasMany(League::class);
    }
}