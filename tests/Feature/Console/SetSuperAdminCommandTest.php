<?php

namespace Tests\Feature\Console;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SetSuperAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_super_admin_when_user_does_not_exist(): void
    {
        config()->set('app.superadmin_email', 'super@example.com');
        config()->set('app.superadmin_password', 'super-secret-password');

        $this->artisan('app:set-super-admin')
            ->expectsOutput('Super admin created with email super@example.com.')
            ->assertSuccessful();

        $user = User::where('email', 'super@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('super_admin', $user->role);
        $this->assertTrue(Hash::check('super-secret-password', $user->password));
        $this->assertNotEmpty($user->username);
    }

    public function test_it_promotes_existing_user_to_super_admin(): void
    {
        config()->set('app.superadmin_email', 'member@example.com');
        config()->set('app.superadmin_password', 'super-secret-password');

        $user = User::factory()->create([
            'email' => 'member@example.com',
            'role' => 'user',
        ]);

        $this->artisan('app:set-super-admin')
            ->expectsOutput('User member@example.com has been promoted to super admin.')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'super_admin',
        ]);
    }

    public function test_it_fails_when_credentials_are_missing(): void
    {
        config()->set('app.superadmin_email', null);
        config()->set('app.superadmin_password', null);

        $this->artisan('app:set-super-admin')
            ->expectsOutput('Missing super admin credentials. Set SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD.')
            ->assertFailed();
    }
}