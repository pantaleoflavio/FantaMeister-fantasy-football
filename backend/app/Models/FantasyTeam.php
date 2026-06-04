<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FantasyTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'user_id',
        'name',
        'slug',
        'logo_path',
        'budget',
        'remaining_budget',
    ];

    protected $casts =
        [
            'budget' => 'decimal:2',
            'remaining_budget' => 'decimal:2',
        ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'fantasy_team_players')
            ->withPivot(
                [
                    'league_id',
                    'assigned_by_user_id',
                    'purchase_price',
                    'assigned_at', 'released_at',
                ])->withTimestamps();
    }
}
