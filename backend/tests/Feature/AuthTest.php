<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        Role::create(['name' => 'user']);
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Mario', 'email' => 'mario@example.com', 'password' => 'password123', 'password_confirmation' => 'password123',
        ]);
        $response->assertCreated()->assertJsonPath('user.email', 'mario@example.com');
    }

    public function test_registered_user_receives_default_role(): void
    {
        $role = Role::create(['name' => 'user']);
        $this->postJson('/api/v1/auth/register', ['name'=>'A','email'=>'a@example.com','password'=>'password123','password_confirmation'=>'password123']);
        $user = User::where('email', 'a@example.com')->firstOrFail();
        $this->assertTrue($user->roles->contains($role));
    }

    public function test_user_can_login_and_logout_and_me(): void
    {
        Role::create(['name' => 'user']);
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $user->roles()->attach(Role::firstWhere('name', 'user'));

        $login = $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'password123']);
        $login->assertOk()->assertJsonStructure(['token', 'user']);
        $token = $login->json('token');

        $tokenId = (int) str($token)->before('|')->toString();

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => $tokenId,
        ]);

       $this->getJson('/api/v1/auth/me', [
            'Authorization' => "Bearer {$token}",
        ])
            ->assertOk()
            ->assertJsonPath('data.email', $user->email);

        $this->postJson('/api/v1/auth/logout', [], [
            'Authorization' => "Bearer {$token}",
        ])->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);

        $this->app['auth']->forgetGuards();

        $this->getJson('/api/v1/auth/me', [
            'Authorization' => "Bearer {$token}",
        ])->assertUnauthorized();
    }

    public function test_global_admin_seed_exists(): void
    {
        $this->seed();
        $admin = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->roles->contains('name', 'global_admin'));
    }
    public function test_forgot_and_reset_password_flow(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'pw@example.com']);
        $this->postJson('/api/v1/auth/forgot-password', ['email' => 'pw@example.com'])->assertOk();
        $token = null;

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            }
        );

        $this->assertNotNull($token);

        $this->postJson('/api/v1/auth/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertOk();

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }
}