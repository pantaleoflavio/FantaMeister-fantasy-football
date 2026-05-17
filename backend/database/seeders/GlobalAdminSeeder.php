<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GlobalAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => env('GLOBAL_ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('GLOBAL_ADMIN_NAME', 'Global Admin'),
                'password' => Hash::make(env('GLOBAL_ADMIN_PASSWORD', 'password123')),
            ]
        );

        $role = Role::firstWhere('name', 'global_admin');

        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
