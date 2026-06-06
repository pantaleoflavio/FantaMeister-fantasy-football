<?php

namespace App\Models;

use App\Models\FormationModule;
use App\Models\PlayerRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationModuleRequirement extends Model
{
    use HasFactory;
    
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
