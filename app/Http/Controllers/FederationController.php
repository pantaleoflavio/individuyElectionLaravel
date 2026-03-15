<?php

namespace App\Http\Controllers;

use App\Models\TagTeam;
use App\Models\Wrestler;
use App\Models\Federation;

class FederationController extends Controller
{
    public function index()
    {
        $federations = Federation::all();
        if ($federations->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nessuna federazione disponibile.');
        }
        return view('federations.index', compact('federations'));
    }

    public function show($id)
    {
        $federation = Federation::findOrFail($id);

        $wrestlers = Wrestler::where('federation_id', $id)->get();

        $tagTeams = TagTeam::where('federation_id', $id)->get();

        return view('federations.show', compact('federation', 'wrestlers', 'tagTeams'));
    }
}
