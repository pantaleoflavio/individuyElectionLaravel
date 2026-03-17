<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementControllersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_all_management_pages(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.users'))
            ->assertOk()
            ->assertViewIs('admin.users');

        $this->actingAs($admin)
            ->get(route('admin.wrestler'))
            ->assertOk()
            ->assertViewIs('admin.wrestler');

        $this->actingAs($admin)
            ->get(route('admin.tag_team'))
            ->assertOk()
            ->assertViewIs('admin.tag_team');

        $this->actingAs($admin)
            ->get(route('admin.category'))
            ->assertOk()
            ->assertViewIs('admin.category');

        $this->actingAs($admin)
            ->get(route('admin.federation'))
            ->assertOk()
            ->assertViewIs('admin.federation');

        $this->actingAs($admin)
            ->get(route('admin.ranking'))
            ->assertOk()
            ->assertViewIs('admin.ranking');
    }

    public function test_admin_can_promote_standard_user_from_management_controller(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)
            ->patch(route('admin.users.promote', $user->id));

        $response->assertRedirect(route('admin.users'));
        $response->assertSessionHas('success', 'Utente promosso a admin con successo.');

        $user->refresh();
        $this->assertSame('admin', $user->role);
    }
}