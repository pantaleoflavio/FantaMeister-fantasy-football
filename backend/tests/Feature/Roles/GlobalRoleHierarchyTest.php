<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use App\Models\User;
use App\Services\Auth\RegisterUserService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GlobalRoleHierarchyTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_seeder_creates_idempotent_global_role_hierarchy(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(RoleSeeder::class);

        $this->assertDatabaseCount('roles', 3);
        $this->assertDatabaseHas('roles', ['name' => 'super_admin', 'label' => 'Super Admin', 'level' => 100, 'is_system' => true]);
        $this->assertDatabaseHas('roles', ['name' => 'global_admin', 'label' => 'Global Admin', 'level' => 80, 'is_system' => true]);
        $this->assertDatabaseHas('roles', ['name' => 'user', 'label' => 'User', 'level' => 10, 'is_system' => true]);
    }

    public function test_super_admin_has_highest_access_level(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::query()->whereIn('name', ['user', 'super_admin'])->pluck('id'));

        $this->assertTrue($user->isSuperAdmin());
        $this->assertSame(100, $user->highestGlobalRoleLevel());
    }

    public function test_registered_users_receive_normal_user_role(): void
    {
        $this->seed(RoleSeeder::class);

        $result = app(RegisterUserService::class)->execute([
            'name' => 'Registered User',
            'email' => 'registered@example.com',
            'password' => 'password123',
        ]);

        $this->assertTrue($result['user']->hasGlobalRole('user'));
        $this->assertSame(10, $result['user']->highestGlobalRoleLevel());
    }
}
