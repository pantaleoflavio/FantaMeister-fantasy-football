<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'real_club_id', 'external_id', 'first_name', 'last_name', 'display_name', 'slug', 'birth_date', 'quotation', 'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'quotation' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function realClub(): BelongsTo
    {
        return $this->belongsTo(RealClub::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(PlayerRole::class)->withPivot('is_primary')->withTimestamps();
    }
}
