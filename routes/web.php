<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;
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
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create']);
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
});

// Ranking Routes
Route::get('/rankings', [RankingController::class, 'index'])->name('rankings.index');
Route::get('/rankings/show/{ranking}', [RankingController::class, 'show'])->name('rankings.show');

Route::get('/ranking-list-wrestler', [RankingController::class, 'ranking_list_wrestler']);
Route::get('/ranking-list-tag-team', [RankingController::class, 'ranking_list_tag_team']);

// Vote Routes
Route::get('/vote-lists', [VoteController::class, 'index']);
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
Route::get('/federations', [FederationController::class, 'index']);
Route::get('/list-per-fed&{id}', [FederationController::class, 'show'])->name('federations.show');;