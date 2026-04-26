<?php

namespace Tests\Feature\Controller;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\User;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudControllersTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_create_and_delete_wrestler(): void
    {
        $admin = $this->admin();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();

        $create = $this->actingAs($admin)->post(route('admin.wrestler.store'), [
            'name' => 'Test Wrestler',
            'description' => 'Tecnico completo',
            'country' => 'Italy',
            'category_ids' => [$category->id],
            'federation_ids' => [$federation->id],
            'is_active' => true,
        ]);

        $create->assertRedirect(route('admin.wrestler'));
        $this->assertDatabaseHas('wrestlers', ['name' => 'Test Wrestler']);

        $wrestlerId = Wrestler::where('name', 'Test Wrestler')->value('id');

        $delete = $this->actingAs($admin)->delete(route('admin.wrestler.delete', $wrestlerId));
        $delete->assertRedirect(route('admin.wrestler'));
        $this->assertDatabaseMissing('wrestlers', ['id' => $wrestlerId]);
    }

    public function test_admin_can_update_tag_team(): void
    {
        $admin = $this->admin();
        $category = Category::factory()->create();
        $newCategory = Category::factory()->create();
        $federation = Federation::factory()->create();
        $newFederation = Federation::factory()->create();

        $tagTeam = TagTeam::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old description',
            'is_active' => true,
        ]);

        $tagTeam->categories()->sync([$category->id]);
        $tagTeam->federations()->sync([$federation->id]);

        $response = $this->actingAs($admin)->put(route('admin.tag_team.update', $tagTeam->id), [
            'name' => 'New Name',
            'description' => 'New description',
            'image_url' => 'https://example.com/tag-team.jpg',
            'country' => $tagTeam->country,
            'category_ids' => [$newCategory->id],
            'federation_ids' => [$newFederation->id],
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.tag_team'));
        $this->assertDatabaseHas('tag_teams', [
            'id' => $tagTeam->id,
            'name' => 'New Name',
            'description' => 'New description',
        ]);

        $this->assertDatabaseHas('tag_team_category', [
            'tag_team_id' => $tagTeam->id,
            'category_id' => $newCategory->id,
        ]);

        $this->assertDatabaseHas('federation_tag_team', [
            'tag_team_id' => $tagTeam->id,
            'federation_id' => $newFederation->id,
        ]);
    }

    public function test_admin_can_update_wrestler(): void
    {
        $admin = $this->admin();
        $category = Category::factory()->create();
        $newCategory = Category::factory()->create();
        $federation = Federation::factory()->create();
        $newFederation = Federation::factory()->create();

        $wrestler = Wrestler::factory()->create([
            'name' => 'Old Wrestler',
            'description' => 'Old description',
            'is_active' => true,
        ]);

        $wrestler->categories()->sync([$category->id]);
        $wrestler->federations()->sync([$federation->id]);

        $response = $this->actingAs($admin)->put(route('admin.wrestler.update', $wrestler->id), [
            'name' => 'New Wrestler',
            'description' => 'New description',
            'image_url' => 'https://example.com/wrestler.jpg',
            'country' => 'Japan',
            'category_ids' => [$newCategory->id],
            'federation_ids' => [$newFederation->id],
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.wrestler'));

        $this->assertDatabaseHas('wrestlers', [
            'id' => $wrestler->id,
            'name' => 'New Wrestler',
            'description' => 'New description',
        ]);

        $this->assertDatabaseHas('wrestler_category', [
            'wrestler_id' => $wrestler->id,
            'category_id' => $newCategory->id,
        ]);

        $this->assertDatabaseHas('federation_wrestler', [
            'wrestler_id' => $wrestler->id,
            'federation_id' => $newFederation->id,
        ]);
    }

    public function test_admin_can_create_update_and_delete_category(): void
    {
        $admin = $this->admin();

        $create = $this->actingAs($admin)->post(route('admin.category.store'), [
            'name' => 'Puroresu',
        ]);

        $create->assertRedirect(route('admin.category'));
        $this->assertDatabaseHas('categories', ['name' => 'Puroresu']);

        $category = Category::where('name', 'Puroresu')->firstOrFail();

        $update = $this->actingAs($admin)->put(route('admin.category.update', $category->id), [
            'name' => 'Strong Style',
        ]);

        $update->assertRedirect(route('admin.category'));
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Strong Style']);

        $delete = $this->actingAs($admin)->delete(route('admin.category.delete', $category->id));
        $delete->assertRedirect(route('admin.category'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_create_and_update_ranking(): void
    {
        $admin = $this->admin();
        $category = Category::factory()->create();

        $create = $this->actingAs($admin)->post(route('admin.ranking.store'), [
            'name' => 'Best of Year',
            'description' => 'Top yearly ranking',
            'type' => RankingType::Wrestler->value,
            'status' => true,
            'filter_type' => 'category',
            'category_id' => $category->id,
            'includes_inactive' => false,
        ]);

        $create->assertRedirect(route('admin.ranking'));
        $ranking = Ranking::where('name', 'Best of Year')->firstOrFail();

        $update = $this->actingAs($admin)->put(route('admin.ranking.update', $ranking->id), [
            'name' => 'Best of Year Updated',
            'description' => 'Updated description',
            'status' => 1,
            'filter_type' => 'category',
            'category_id' => $category->id,
        ]);

        $update->assertRedirect(route('admin.ranking'));
        $this->assertDatabaseHas('rankings', [
            'id' => $ranking->id,
            'name' => 'Best of Year Updated',
            'status' => 1,
        ]);
    }

    public function test_admin_can_create_only_one_federation_ranking_from_dedicated_action(): void
    {
        $admin = $this->admin();

        $first = $this->actingAs($admin)->post(route('admin.ranking.federation.create'));
        $first->assertRedirect(route('admin.ranking'));
        $first->assertSessionHas('success', 'Ranking federazioni creato con successo.');

        $this->assertDatabaseHas('rankings', [
            'type' => RankingType::Federation->value,
            'name' => 'Ranking Federazioni',
        ]);

        $second = $this->actingAs($admin)->post(route('admin.ranking.federation.create'));
        $second->assertRedirect(route('admin.ranking'));
        $second->assertSessionHas('error', 'Il ranking federazioni esiste già.');

        $this->assertSame(1, Ranking::where('type', RankingType::Federation->value)->count());
    }

    public function test_edit_federation_ranking_hides_filter_fields_and_update_resets_filters(): void
    {
        $admin = $this->admin();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();

        $ranking = Ranking::factory()->create([
            'type' => RankingType::Federation->value,
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'country' => 'Italy',
            'filter_type' => 'multiple',
        ]);

        $ranking->categories()->sync([$category->id]);
        $ranking->federations()->sync([$federation->id]);
        $ranking->rankingCountries()->create(['country' => 'Italy']);

        $edit = $this->actingAs($admin)->get(route('admin.ranking.edit', $ranking->id));
        $edit->assertOk();
        $edit->assertDontSee('Categorie (facoltative, selezione multipla):');
        $edit->assertDontSee('Federazioni (facoltative, selezione multipla):');
        $edit->assertDontSee('Nazionalità (una o più, separate da virgola):');

        $update = $this->actingAs($admin)->put(route('admin.ranking.update', $ranking->id), [
            'name' => 'Federation Ranking Updated',
            'description' => 'Updated',
            'status' => 1,
            // injected filter payload should be ignored for federation rankings
            'category_ids' => [$category->id],
            'federation_ids' => [$federation->id],
            'countries_text' => 'Japan',
        ]);

        $update->assertRedirect(route('admin.ranking'));

        $ranking->refresh();
        $this->assertSame('Federation Ranking Updated', $ranking->name);
        $this->assertNull($ranking->category_id);
        $this->assertNull($ranking->federation_id);
        $this->assertNull($ranking->country);
        $this->assertSame('none', $ranking->filter_type);

        $this->assertCount(0, $ranking->categories);
        $this->assertCount(0, $ranking->federations);
        $this->assertCount(0, $ranking->rankingCountries);
    }
}