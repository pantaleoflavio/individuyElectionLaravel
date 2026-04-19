<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;
use App\Models\TagTeam;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_rankings_index_is_accessible(): void
    {
        $categories = Category::factory()->count(3)->create();

        foreach ($categories as $category) {
            Ranking::factory()->create([
                'category_id' => $category->id,
            ]);
        }

        $response = $this->get(route('rankings.index'));

        $response->assertOk();
        $response->assertViewIs('rankings.index');
        $response->assertViewHas('rankings');
    }

    public function test_show_wrestler_ranking_displays_participants_ordered_by_average(): void
    {
        $category = Category::factory()->create();

        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'wrestler',
            'category_id' => $category->id,
        ]);

        $w1 = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
        ]);
        $w2 = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
        ]);

        RankingWrestlerAverage::create([
            'ranking_id' => $ranking->id,
            'wrestler_id' => $w1->id,
            'votes_count' => 5,
            'votes_sum' => 30,
            'average_vote' => 6.0,
        ]);

        RankingWrestlerAverage::create([
            'ranking_id' => $ranking->id,
            'wrestler_id' => $w2->id,
            'votes_count' => 5,
            'votes_sum' => 45,
            'average_vote' => 9.0,
        ]);

        $response = $this->get(route('rankings.show', $ranking->id));

        $response->assertOk();
        $response->assertViewIs('rankings.show');
        $response->assertViewHas('participants', function ($participants) use ($w2, $w1) {
            return $participants->count() === 2
                && $participants->first()->participant->id === $w2->id
                && $participants->last()->participant->id === $w1->id;
        });
    }

    public function test_show_tag_team_ranking_displays_participants_ordered_by_average(): void
    {
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'tag team',
            'category_id' => $category->id,
        ]);

        $t1 = TagTeam::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
        ]);
        $t2 = TagTeam::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
        ]);

        RankingTagTeamAverage::create([
            'ranking_id' => $ranking->id,
            'tag_team_id' => $t1->id,
            'votes_count' => 4,
            'votes_sum' => 20,
            'average_vote' => 5.0,
        ]);

        RankingTagTeamAverage::create([
            'ranking_id' => $ranking->id,
            'tag_team_id' => $t2->id,
            'votes_count' => 4,
            'votes_sum' => 36,
            'average_vote' => 9.0,
        ]);

        $response = $this->get(route('rankings.show', $ranking->id));

        $response->assertOk();
        $response->assertViewIs('rankings.show');
        $response->assertViewHas('participants', function ($participants) use ($t2, $t1) {
            return $participants->count() === 2
                && $participants->first()->participant->id === $t2->id
                && $participants->last()->participant->id === $t1->id;
        });
    }

    public function test_wrestler_ranking_list_shows_message_when_no_active_rankings(): void
    {
        $response = $this->get('/ranking-list-wrestler');

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Nessuna votazione disponibile per i wrestler.');
    }

    public function test_tag_team_ranking_list_shows_message_when_no_active_rankings(): void
    {
        $response = $this->get('/ranking-list-tag-team');

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Nessuna votazione disponibile per i tag team.');
    }

    public function test_tag_team_ranking_list_accepts_legacy_type_formats(): void
    {
        $category = Category::factory()->create();

        Ranking::factory()->create([
            'name' => 'Tag Team Legacy',
            'type' => 'tag_team',
            'status' => true,
            'category_id' => $category->id,
        ]);

        $response = $this->get('/ranking-list-tag-team');

        $response->assertOk();
        $response->assertViewIs('votes.tag_team.ranking-list');
        $response->assertSee('Tag Team Legacy');
    }
}