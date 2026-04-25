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

        $wrestlers = Wrestler::with(['federations', 'federation'])
            ->where(function ($query) use ($id) {
                $query->where('federation_id', $id)
                    ->orWhereHas('federations', function ($federationsQuery) use ($id) {
                        $federationsQuery->where('federations.id', $id);
                    });
            })
            ->distinct()
            ->get();

        $tagTeams = TagTeam::with(['federations', 'federation'])
            ->where(function ($query) use ($id) {
                $query->where('federation_id', $id)
                    ->orWhereHas('federations', function ($federationsQuery) use ($id) {
                        $federationsQuery->where('federations.id', $id);
                    });
            })
            ->distinct()
            ->get();

        return view('federations.show', compact('federation', 'wrestlers', 'tagTeams'));
    }
}
