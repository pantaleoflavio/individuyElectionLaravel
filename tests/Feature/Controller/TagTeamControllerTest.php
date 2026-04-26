<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use App\Models\Federation;
use App\Models\TagTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_team_show_page_is_accessible(): void
    {
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();

        $tagTeam = TagTeam::factory()->create([
            'name' => 'The Golden Pair',
            'description' => 'High flying duo',
        ]);
        
        $tagTeam->categories()->sync([$category->id]);
        $tagTeam->federations()->sync([$federation->id]);
        $response = $this->get(route('tag-teams.show', $tagTeam->id));

        $response->assertOk();
        $response->assertViewIs('tag_teams.show');
        $response->assertSee('The Golden Pair');
    }
}