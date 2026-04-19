<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use App\Models\Federation;
use App\Models\Wrestler;
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

    public function test_federation_show_includes_wrestlers_from_pivot_relationship(): void
    {
        $federation = Federation::factory()->create(['name' => 'NJPW']);
        $otherFederation = Federation::factory()->create(['name' => 'AEW']);
        $category = Category::factory()->create();

        $pivotOnlyWrestler = Wrestler::factory()->create([
            'name' => 'Will Ospreay',
            'category_id' => $category->id,
            'federation_id' => $otherFederation->id,
        ]);

        $pivotOnlyWrestler->federations()->sync([$federation->id, $otherFederation->id]);

        $response = $this->get(route('federations.show', $federation->id));

        $response->assertOk();
        $response->assertSeeText('Will Ospreay');
    }
}