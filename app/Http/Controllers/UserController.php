<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        // Recupera solo i voti relativi ai wrestler, includendo il modello wrestler e il ranking
        $wrestlerVotes  = $user->votesWrestler()->with(['wrestler', 'ranking'])->get();

        // Recupera solo i voti relativi ai Tag Team, includendo il modello Tag Team e il ranking
        $tagTeamVotes  = $user->votesTagTeam()->with(['tagTeam', 'ranking'])->get();

        return view('user.profile', compact('user', 'wrestlerVotes', 'tagTeamVotes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
