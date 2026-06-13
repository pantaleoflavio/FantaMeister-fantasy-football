<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'super_admin', 'label' => 'Super Admin', 'level' => 100, 'is_system' => true],
            ['name' => 'global_admin', 'label' => 'Global Admin', 'level' => 80, 'is_system' => true],
            ['name' => 'user', 'label' => 'User', 'level' => 10, 'is_system' => true],
        ] as $role) {
            Role::query()->updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
