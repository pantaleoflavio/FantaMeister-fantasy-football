<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationModuleRequirement extends Model
{
    protected $fillable =
        [
            'formation_module_id',
            'player_role_id',
            'required_count',
        ];

    public function formationModule(): BelongsTo
    {
        return $this->belongsTo(FormationModule::class);
    }

    public function playerRole(): BelongsTo
    {
        return $this->belongsTo(PlayerRole::class);
    }
}
