<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class GlobalAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user=User::firstOrCreate(
            ['email'=>'admin@example.com'],
            ['name'=>'Global Admin','password'=>'password123']
        ); 
            
        $role=Role::firstWhere('name','global_admin');
            
        if($role){
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
