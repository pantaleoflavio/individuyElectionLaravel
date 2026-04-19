<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\TagTeamController;
use App\Http\Controllers\WrestlerController;
use App\Http\Controllers\FederationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\WrestlerManagementController;
use App\Http\Controllers\Admin\TagTeamManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\FederationManagementController;
use App\Http\Controllers\Admin\RankingManagementController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function(){
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

// User Routes
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('user.destroy');
});

// Admin Routes
Route::middleware(['auth.custom', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Admin
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/admin/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.delete');
    Route::patch('/admin/users/{id}/promote', [UserManagementController::class, 'promote'])->name('admin.users.promote');
    Route::patch('/admin/users/{id}/demote', [UserManagementController::class, 'demote'])->name('admin.users.demote');
   
    // Wrestler Admin
    Route::get('/admin/wrestler', [WrestlerManagementController::class, 'index'])->name('admin.wrestler');
    Route::get('/admin/wrestler/add', [WrestlerManagementController::class, 'create'])->name('admin.wrestler.add');
    Route::post('/admin/wrestler', [WrestlerManagementController::class, 'store'])->name('admin.wrestler.store');
    Route::get('/admin/wrestler/{id}/edit', [WrestlerManagementController::class, 'edit'])->name('admin.wrestler.edit');
    Route::put('/admin/wrestler/{id}', [WrestlerManagementController::class, 'update'])->name('admin.wrestler.update');
    Route::delete('/admin/wrestler/{id}/delete', [WrestlerManagementController::class, 'destroy'])->name('admin.wrestler.delete');

    // Tag Teams Admin
    Route::get('/admin/tag_team', [TagTeamManagementController::class, 'index'])->name('admin.tag_team');
    Route::get('/admin/tag_team/add', [TagTeamManagementController::class, 'create'])->name('admin.tag_team.add');
    Route::post('/admin/tag_team', [TagTeamManagementController::class, 'store'])->name('admin.tag_team.store');
    Route::get('/admin/tag_team/{id}/edit', [TagTeamManagementController::class, 'edit'])->name('admin.tag_team.edit');
    Route::put('/admin/tag_team/{id}', [TagTeamManagementController::class, 'update'])->name('admin.tag_team.update');
    Route::delete('/admin/tag_team/{id}/delete', [TagTeamManagementController::class, 'destroy'])->name('admin.tag_team.delete');

    // Category Admin
    Route::get('/admin/category', [CategoryManagementController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/{id}/edit', [CategoryManagementController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/{id}', [CategoryManagementController::class, 'update'])->name('admin.category.update');
    Route::post('/admin/category', [CategoryManagementController::class, 'store'])->name('admin.category.store');
    Route::delete('/admin/category/{id}/delete', [CategoryManagementController::class, 'destroy'])->name('admin.category.delete');

    // Federation Admin
    Route::get('/admin/federation', [FederationManagementController::class, 'index'])->name('admin.federation');
    Route::get('/admin/federation/{id}/edit', [FederationManagementController::class, 'edit'])->name('admin.federation.edit');
    Route::put('/admin/federation/{id}', [FederationManagementController::class, 'update'])->name('admin.federation.update');
    Route::post('/admin/federation', [FederationManagementController::class, 'store'])->name('admin.federation.store');
    Route::delete('/admin/federation/{id}/delete', [FederationManagementController::class, 'destroy'])->name('admin.federation.delete');

    // Ranking Admin
    Route::get('/admin/ranking', [RankingManagementController::class, 'index'])->name('admin.ranking');
    Route::get('/admin/ranking/{id}/edit', [RankingManagementController::class, 'edit'])->name('admin.ranking.edit');
    Route::put('/admin/ranking/{id}', [RankingManagementController::class, 'update'])->name('admin.ranking.update');
    Route::post('/admin/ranking', [RankingManagementController::class, 'store'])->name('admin.ranking.store');
    Route::delete('/admin/ranking/{id}/delete', [RankingManagementController::class, 'destroy'])->name('admin.ranking.delete');
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
Route::get('/wrestlers/{wrestler}', [WrestlerController::class, 'show'])->name('wrestlers.show');
Route::get('/wrestler-candidates', [WrestlerController::class, 'candidates']);

// Tag Team Routes
Route::get('/tag-team-candidates', [TagTeamController::class, 'candidates']);

// Feds Routes
Route::get('/federations', [FederationController::class, 'index'])->name('federations.index');
Route::get('/list-per-fed&{id}', [FederationController::class, 'show'])->name('federations.show');