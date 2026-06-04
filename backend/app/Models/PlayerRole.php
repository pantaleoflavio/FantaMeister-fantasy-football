<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlayerRole extends Model
{
    protected $fillable = [
        'key', 'label', 'sort_order',
    ];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot('is_primary')->withTimestamps();
    }
}
