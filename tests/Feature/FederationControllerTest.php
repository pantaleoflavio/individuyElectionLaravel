<?php

namespace Tests\Feature;

use App\Models\Federation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FederationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_federations_index_shows_message_when_empty(): void
    {
        $response = $this->get(route('federations.index'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Nessuna federazione disponibile.');
    }

    public function test_federations_index_lists_available_federations(): void
    {
        $federation = Federation::factory()->create(['name' => 'NJPW']);

        $response = $this->get(route('federations.index'));

        $response->assertOk();
        $response->assertSeeText($federation->name);
    }
}