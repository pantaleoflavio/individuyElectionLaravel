<?php

namespace App\Http\Controllers;

use App\Models\TagTeam;
use App\Models\Wrestler;
use App\Models\Federation;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    public function index()
    {
        $federations = Federation::all();
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
