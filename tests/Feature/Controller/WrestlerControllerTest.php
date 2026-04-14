<?php

namespace Tests\Feature\Controller;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WrestlerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidates_are_filtered_by_ranking_category_federation_and_country(): void
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();
        $fedA = Federation::factory()->create();
        $fedB = Federation::factory()->create();

        $ranking = Ranking::factory()->create([
            'type' => RankingType::Wrestler->value,
            'category_id' => $categoryA->id,
            'federation_id' => $fedA->id,
            'country' => 'Japan',
            'status' => true,
            'includes_inactive' => false,
        ]);

        $eligible = Wrestler::factory()->create([
            'name' => 'Eligible',
            'country' => 'Japan',
            'category_id' => $categoryA->id,
            'federation_id' => $fedA->id,
            'is_active' => true,
        ]);
        $eligible->categories()->sync([$categoryA->id, $categoryB->id]);
        $eligible->federations()->sync([$fedA->id, $fedB->id]);

        $wrongCountry = Wrestler::factory()->create([
            'country' => 'Italy',
            'category_id' => $categoryA->id,
            'federation_id' => $fedA->id,
            'is_active' => true,
        ]);
        $wrongCountry->categories()->sync([$categoryA->id]);
        $wrongCountry->federations()->sync([$fedA->id]);

        $wrongFed = Wrestler::factory()->create([
            'country' => 'Japan',
            'category_id' => $categoryA->id,
            'federation_id' => $fedB->id,
            'is_active' => true,
        ]);
        $wrongFed->categories()->sync([$categoryA->id]);
        $wrongFed->federations()->sync([$fedB->id]);

        $response = $this->get('/wrestler-candidates?ranking_id=' . $ranking->id);

        $response->assertOk();
        $response->assertSee('Eligible');
        $response->assertDontSee($wrongCountry->name);
        $response->assertDontSee($wrongFed->name);
    }
}
