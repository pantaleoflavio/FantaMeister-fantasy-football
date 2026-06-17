<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerRole extends Model
{
    protected $fillable = [
        'key', 'label', 'sort_order',
    ];

    public function playerSeasonRegistrations(): HasMany
    {
        return $this->hasMany(PlayerSeasonRegistration::class);
    }
}
