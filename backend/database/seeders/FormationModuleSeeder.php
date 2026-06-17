<?php

namespace Database\Seeders;

use App\Models\FormationModule;
use App\Models\FormationModuleRequirement;
use App\Models\PlayerRole;
use Illuminate\Database\Seeder;

class FormationModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            '3-4-3' => ['goalkeeper' => 1, 'defender' => 3, 'midfielder' => 4, 'forward' => 3],
            '3-5-2' => ['goalkeeper' => 1, 'defender' => 3, 'midfielder' => 5, 'forward' => 2],
            '4-3-3' => ['goalkeeper' => 1, 'defender' => 4, 'midfielder' => 3, 'forward' => 3],
            '4-4-2' => ['goalkeeper' => 1, 'defender' => 4, 'midfielder' => 4, 'forward' => 2],
            '4-5-1' => ['goalkeeper' => 1, 'defender' => 4, 'midfielder' => 5, 'forward' => 1],
            '5-3-2' => ['goalkeeper' => 1, 'defender' => 5, 'midfielder' => 3, 'forward' => 2],
            '5-4-1' => ['goalkeeper' => 1, 'defender' => 5, 'midfielder' => 4, 'forward' => 1],
        ];

        $roles = PlayerRole::query()->pluck('id', 'key');

        foreach ($modules as $name => $requirements) {
            $module = FormationModule::query()->updateOrCreate(
                ['name' => $name],
                ['label' => $name, 'is_active' => true],
            );

            foreach ($requirements as $roleKey => $count) {
                FormationModuleRequirement::query()->updateOrCreate(
                    ['formation_module_id' => $module->id, 'player_role_id' => $roles[$roleKey]],
                    ['required_count' => $count],
                );
            }
        }
    }
}
