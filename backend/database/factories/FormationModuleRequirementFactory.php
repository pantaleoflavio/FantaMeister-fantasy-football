<?php

namespace Database\Factories;

use App\Models\FormationModule;
use App\Models\FormationModuleRequirement;
use App\Models\PlayerRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormationModuleRequirement>
 */
class FormationModuleRequirementFactory extends Factory
{
    protected $model = FormationModuleRequirement::class;

    public function definition(): array
    {
        return [
            'formation_module_id' => FormationModule::factory(),
            'player_role_id' => PlayerRole::query()->firstOrCreate(
                ['key' => 'defender'],
                ['label' => 'Defender', 'sort_order' => 2],
            )->id,
            'required_count' => 4,
        ];
    }
}
