<?php

namespace Tests\Feature\Controller;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\User;
use App\Models\VoteFederation;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use App\Models\Wrestler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_submit_wrestler_vote(): void
    {
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'wrestler',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $wrestler = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        $response = $this->post(route('vote.wrestler.store'), [
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 8.5,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Devi essere loggato per accedere a questa sezione.');
        $this->assertDatabaseCount('votes_wrestler', 0);
    }

    public function test_user_can_submit_wrestler_vote_once(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'wrestler',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $wrestler = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post(route('vote.wrestler.store'), [
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 7.5,
        ]);

        $response->assertRedirect(route('user.profile'));
        $response->assertSessionHas('success', 'Il tuo voto è stato salvato con successo.');

        $this->assertDatabaseHas('votes_wrestler', [
            'user_id' => $user->id,
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 7.5,
        ]);
    }

    public function test_user_can_update_existing_wrestler_vote(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'wrestler',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $wrestler = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        VoteWrestler::create([
            'user_id' => $user->id,
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 9,
        ]);

        $response = $this->actingAs($user)->post(route('vote.wrestler.store'), [
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);

        $response->assertRedirect(route('user.profile'));

        $this->assertDatabaseCount('votes_wrestler', 1);

        $this->assertDatabaseHas('votes_wrestler', [
            'user_id' => $user->id,
            'wrestler_id' => $wrestler->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);
    }

    public function test_user_cannot_submit_wrestler_vote_to_tag_team_ranking(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'tag team',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $wrestler = Wrestler::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->from('/voteWrestler/' . $wrestler->id . '/' . $ranking->id)
            ->post(route('vote.wrestler.store'), [
                'wrestler_id' => $wrestler->id,
                'ranking_id' => $ranking->id,
                'vote' => 6,
            ]);

        $response->assertRedirect('/voteWrestler/' . $wrestler->id . '/' . $ranking->id);
        $response->assertSessionHas('error', 'Questo ranking non accetta votazioni per wrestler.');
        $this->assertDatabaseCount('votes_wrestler', 0);
    }

    public function test_user_can_submit_tag_team_vote_once(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'tag team',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $tagTeam = TagTeam::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post(route('vote.tagTeam.store'), [
            'tag_team_id' => $tagTeam->id,
            'ranking_id' => $ranking->id,
            'vote' => 9.5,
        ]);

        $response->assertRedirect(route('user.profile'));
        $response->assertSessionHas('success', 'Il tuo voto è stato salvato con successo.');

        $this->assertDatabaseHas('votes_tag_team', [
            'user_id' => $user->id,
            'tag_team_id' => $tagTeam->id,
            'ranking_id' => $ranking->id,
            'vote' => 9.5,
        ]);
    }

    public function test_user_can_update_existing_tag_team_vote(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => 'tag team',
            'category_id' => $category->id,
            'status' => true,
        ]);
        $tagTeam = TagTeam::factory()->create([
            'category_id' => $category->id,
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        VoteTagTeam::create([
            'user_id' => $user->id,
            'tag_team_id' => $tagTeam->id,
            'ranking_id' => $ranking->id,
            'vote' => 9,
        ]);

        $response = $this->actingAs($user)->post(route('vote.tagTeam.store'), [
            'tag_team_id' => $tagTeam->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);

        $response->assertRedirect(route('user.profile'));
        $this->assertDatabaseCount('votes_tag_team', 1);
        $this->assertDatabaseHas('votes_tag_team', [
            'user_id' => $user->id,
            'tag_team_id' => $tagTeam->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);
    }

    public function test_guest_cannot_submit_federation_vote(): void
    {
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => RankingType::Federation->value,
            'status' => true,
        ]);

        $response = $this->post(route('vote.federation.store'), [
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 8.5,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Devi essere loggato per accedere a questa sezione.');
        $this->assertDatabaseCount('votes_federation', 0);
    }

    public function test_user_can_submit_federation_vote_once(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => RankingType::Federation->value,
            'status' => true,
        ]);

        $response = $this->actingAs($user)->post(route('vote.federation.store'), [
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 7.5,
        ]);

        $response->assertRedirect(route('user.profile'));
        $response->assertSessionHas('success', 'Il tuo voto è stato salvato con successo.');

        $this->assertDatabaseHas('votes_federation', [
            'user_id' => $user->id,
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 7.5,
        ]);
    }

    public function test_user_can_update_existing_federation_vote(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => RankingType::Federation->value,
            'status' => true,
        ]);

        VoteFederation::create([
            'user_id' => $user->id,
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 9,
        ]);

        $response = $this->actingAs($user)->post(route('vote.federation.store'), [
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);

        $response->assertRedirect(route('user.profile'));
        $this->assertDatabaseCount('votes_federation', 1);
        $this->assertDatabaseHas('votes_federation', [
            'user_id' => $user->id,
            'federation_id' => $federation->id,
            'ranking_id' => $ranking->id,
            'vote' => 8,
        ]);
    }

    public function test_user_cannot_submit_federation_vote_to_wrestler_ranking(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $federation = Federation::factory()->create();
        $ranking = Ranking::factory()->create([
            'type' => RankingType::Wrestler->value,
            'status' => true,
        ]);

        $response = $this->actingAs($user)->from('/voteFederation/' . $federation->id . '/' . $ranking->id)
            ->post(route('vote.federation.store'), [
                'federation_id' => $federation->id,
                'ranking_id' => $ranking->id,
                'vote' => 6,
            ]);

        $response->assertRedirect('/voteFederation/' . $federation->id . '/' . $ranking->id);
        $response->assertSessionHas('error', 'Questo ranking non accetta votazioni per federazioni.');
        $this->assertDatabaseCount('votes_federation', 0);
    }
}