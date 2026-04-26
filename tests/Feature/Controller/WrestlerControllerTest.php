<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use App\Models\Federation;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WrestlerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_wrestler_page_displays_details(): void
    {
        $category = Category::factory()->create(['name' => 'Strong Style']);
        $federation = Federation::factory()->create(['name' => 'NJPW']);

        $wrestler = Wrestler::factory()->create([
            'name' => 'Kazuchika Okada',
            'description' => 'Main event wrestler',
            'country' => 'Japan',
            'image_url' => 'https://example.com/okada.jpg',
        ]);

        $wrestler->categories()->sync([$category->id]);
        $wrestler->federations()->sync([$federation->id]);

        $response = $this->get(route('wrestlers.show', $wrestler->id));

        $response->assertOk();
        $response->assertSee('Kazuchika Okada');
        $response->assertSee('Main event wrestler');
        $response->assertSee('Japan');
        $response->assertSee('Strong Style');
        $response->assertSee('NJPW');
    }
}