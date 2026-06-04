<?php

namespace Database\Seeders;

use App\Models\PlayerRole;
use Illuminate\Database\Seeder;

class PlayerRoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            [
                ['key' => 'goalkeeper', 'label' => 'Goalkeeper', 'sort_order' => 1],
                ['key' => 'defender', 'label' => 'Defender', 'sort_order' => 2],
                ['key' => 'midfielder', 'label' => 'Midfielder', 'sort_order' => 3],
                ['key' => 'forward', 'label' => 'Forward', 'sort_order' => 4],
            ] as $role
        ) {
            PlayerRole::query()->updateOrCreate(['key' => $role['key']], $role);
        }
    }
}
