<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/profile_images', $imageName);
            $user->image_path = 'profile_images/' . $imageName;
        }
    
        $user->save();
    
        return redirect()->route('user.edit')->with('success', 'Profilo aggiornato con successo!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
