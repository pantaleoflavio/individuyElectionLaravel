<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
   use RefreshDatabase;

    public function test_guest_can_view_reset_password_form(): void
    {
        $response = $this->get(route('password.reset', ['token' => 'sample-token']));

        $response->assertOk();
        $response->assertViewIs('auth.reset-password');
    }

    public function test_store_requires_token_email_and_password_fields(): void
    {
        $response = $this->from(route('password.reset', ['token' => 'missing']))->post(route('password.store'), []);

        $response->assertRedirect(route('password.reset', ['token' => 'missing']));
        $response->assertSessionHasErrors(['token', 'email', 'password']);
    }

    public function test_it_resets_password_with_a_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'new-password@example.com',
            'password' => 'password',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $token = null;

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
            $token = $notification->token;

            return true;
        });

        $response = $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'my-new-password-123',
            'password_confirmation' => 'my-new-password-123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('my-new-password-123', $user->fresh()->password));
    }

    public function test_it_does_not_reset_password_with_invalid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'new-password@example.com',
            'password' => 'password',
        ]);

        $response = $this->from(route('password.reset', ['token' => 'invalid-token']))->post(route('password.store'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'my-new-password-123',
            'password_confirmation' => 'my-new-password-123',
        ]);

        $response->assertRedirect(route('password.reset', ['token' => 'invalid-token']));
        $response->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
