<?php

namespace Tests\Feature\Controller;

use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_loads_without_query(): void
    {
        $response = $this->get(route('search.index'));

        $response->assertOk();
        $response->assertSeeText('Inserisci un testo nella barra di ricerca');
    }

    public function test_search_returns_matching_results_for_each_entity(): void
    {
        Wrestler::factory()->create(['name' => 'Kenny Omega']);
        TagTeam::factory()->create(['name' => 'Omega Lovers']);
        Federation::factory()->create(['name' => 'Omega Wrestling']);
        Ranking::factory()->create(['name' => 'Best Omega Ranking']);

        $response = $this->get(route('search.index', ['query' => 'Omega']));

        $response->assertOk();
        $response->assertSeeText('Kenny Omega');
        $response->assertSeeText('Omega Lovers');
        $response->assertSeeText('Omega Wrestling');
        $response->assertSeeText('Best Omega Ranking');
    }
}