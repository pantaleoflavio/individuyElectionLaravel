<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagTeamController;
use App\Http\Controllers\WrestlerController;
use App\Http\Controllers\FederationController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Middleware\RedirectIfNotAuthenticated;

Route::get('/', function () {
    return view('index');
});

// Auth Routes
Route::middleware('guest')->group(function(){
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

// User Routes
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
});

// Admin Routes
Route::middleware(['auth.custom', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Wrestler Admin
    Route::get('/admin/wrestler', [WrestlerController::class, 'wrestler'])->name('admin.wrestler');
    Route::get('/admin/wrestler/add', [AdminController::class, 'add_wrestler'])->name('admin.wrestler.add');
    Route::post('/admin/wrestler', [AdminController::class, 'store_wrestler'])->name('admin.wrestler.store');
    Route::get('/admin/wrestler/{id}/edit', [AdminController::class, 'edit_wrestler'])->name('admin.wrestler.edit');
    Route::put('/admin/wrestler/{id}', [AdminController::class, 'update_wrestler'])->name('admin.wrestler.update');
    Route::delete('/admin/wrestler/{id}/delete', [AdminController::class, 'delete_wrestler'])->name('admin.wrestler.delete');

    // Tag Teams Admin
    Route::get('/admin/tag_team', [TagTeamController::class, 'tag_team'])->name('admin.tag_team');
    Route::get('/admin/tag_team/add', [AdminController::class, 'add_tag_team'])->name('admin.tag_team.add');
    Route::post('/admin/tag_team', [AdminController::class, 'store_tag_team'])->name('admin.tag_team.store');
    Route::get('/admin/tag_team/{id}/edit', [AdminController::class, 'edit_tag_team'])->name('admin.tag_team.edit');
    Route::put('/admin/tag_team/{id}', [AdminController::class, 'update_tag_team'])->name('admin.tag_team.update');
    Route::delete('/admin/tag_team/{id}/delete', [AdminController::class, 'delete_tag_team'])->name('admin.tag_team.delete');

    // Category Admin
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/{id}', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::post('/admin/category', [AdminController::class, 'store_category'])->name('admin.category.store');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'delete_category'])->name('admin.category.delete');

    // Federation Admin
    Route::get('/admin/federation', [FederationController::class, 'admin_index'])->name('admin.federation');
    Route::get('/admin/federation/{id}/edit', [AdminController::class, 'edit_federation'])->name('admin.federation.edit');
    Route::put('/admin/federation/{id}', [AdminController::class, 'update_federation'])->name('admin.federation.update');
    Route::post('/admin/federation', [AdminController::class, 'store_federation'])->name('admin.federation.store');
    Route::delete('/admin/federation/{id}/delete', [AdminController::class, 'delete_federation'])->name('admin.federation.delete');

    // Ranking Admin
    Route::get('/admin/ranking', [RankingController::class, 'admin_index'])->name('admin.ranking');
    Route::get('/admin/ranking/{id}/edit', [AdminController::class, 'edit_ranking'])->name('admin.ranking.edit');
    Route::put('/admin/ranking/{id}', [AdminController::class, 'update_ranking'])->name('admin.ranking.update');
    Route::post('/admin/ranking', [AdminController::class, 'store_ranking'])->name('admin.ranking.store');
    Route::delete('/admin/ranking/{id}/delete', [AdminController::class, 'delete_ranking'])->name('admin.ranking.delete');
});

// Ranking Routes
Route::get('/rankings', [RankingController::class, 'index'])->name('rankings.index');
Route::get('/rankings/show/{ranking}', [RankingController::class, 'show'])->name('rankings.show');

Route::get('/ranking-list-wrestler', [RankingController::class, 'ranking_list_wrestler']);
Route::get('/ranking-list-tag-team', [RankingController::class, 'ranking_list_tag_team']);

// Vote Routes
Route::get('/vote-lists', [VoteController::class, 'index'])->name('vote.lists.index');
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/voteWrestler/{wrestler}/{ranking}', [VoteController::class, 'showWrestlerVoteForm'])->name('vote.wrestler.form');
    Route::post('/voteWrestler', [VoteController::class, 'wrestlerVoteStore'])->name('vote.wrestler.store');
    Route::get('/voteTagTeam/{tagTeam}/{ranking}', [VoteController::class, 'showTagTeamVoteForm'])->name('vote.tagTeam.form');
    Route::post('/voteTagTeam', [VoteController::class, 'tagTeamVoteStore'])->name('vote.tagTeam.store');
});

// Wrestler Routes
Route::get('/wrestler-candidates', [WrestlerController::class, 'candidates']);

// Tag Team Routes
Route::get('/tag-team-candidates', [TagTeamController::class, 'candidates']);


// Feds Routes
Route::get('/federations', [FederationController::class, 'index'])->name('federations.index');
Route::get('/list-per-fed&{id}', [FederationController::class, 'show'])->name('federations.show');