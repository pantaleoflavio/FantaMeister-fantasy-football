<?php

namespace App\Models;

use App\Models\Formation;
use App\Models\Player;
use App\Models\PlayerRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationPlayer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'formation_id',
        'player_id',
        'player_role_id',
        'slot_type',
        'position_index',
        'is_captain',
    ];

    protected $casts = [
        'is_captain' => 'boolean',
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function playerRole(): BelongsTo
    {
        return $this->belongsTo(PlayerRole::class);
    }
}
