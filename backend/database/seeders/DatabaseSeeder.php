<?php

namespace Database\Seeders;

use Database\Seeders\FormationModuleSeeder;
use Database\Seeders\GlobalAdminSeeder;
use Database\Seeders\LeagueRoleSeeder;
use Database\Seeders\LeagueStatusSeeder;
use Database\Seeders\LeagueTypeSeeder;
use Database\Seeders\PlayerRoleSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            GlobalAdminSeeder::class,
            PlayerRoleSeeder::class,
            LeagueStatusSeeder::class,
            LeagueTypeSeeder::class,
            LeagueRoleSeeder::class,
            FormationModuleSeeder::class,
        ]);
    }
}
