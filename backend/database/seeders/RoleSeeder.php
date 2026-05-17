<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    { 
        Role::firstOrCreate([
            'name' => 'global_admin',
        ]);

        Role::firstOrCreate([
            'name' => 'user',
        ]);
    }
}
