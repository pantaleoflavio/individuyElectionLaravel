<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Ranking;
use App\Models\Wrestler;
use App\Models\Federation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Auth::user(); // Recupera l'utente attualmente autenticato
        
        // Numero di lottatori per federazione
        $federationsWithCounts = Federation::withCount(['wrestler', 'tag_team'])->get();
        
        // Numero di voti per ranking (divisi per tipo)
        $wrestlerRankings = Ranking::where('type', 'wrestler')->withCount('votesWrestler')->get();
        $tagTeamRankings = Ranking::where('type', 'tag team')->withCount('votesTagTeam')->get();
        
        // Numero totale di utenti
        $totalUsers = User::count();
    
        return view('admin.dashboard', compact(
            'admin',
            'federationsWithCounts',
            'wrestlerRankings',
            'tagTeamRankings',
            'totalUsers'
        ));
    }

    public function edit_wrestler($wrestlerId)
    {
        $wrestler = Wrestler::findOrFail($wrestlerId);
        $federations = Federation::all();
        $categories = Category::all();
        
        return view('admin.edit-wrestler', compact('wrestler', 'federations', 'categories'));
    }

    public function update_wrestler(Request $request, $id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->update($request->all());
        
        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiornato con successo');
    }

    public function delete_wrestler(Request $request, $id)
    {
        
        $wrestler = Wrestler::findOrFail($id);

        $wrestler->delete();

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler eliminato con successo');
    }

    public function add_wrestler()
    {
        $federations = Federation::all();
        $categories = Category::all();
        return view('admin.add-wrestler', compact('federations', 'categories'));
    }

    public function store_wrestler(Request $request)
    {
        $wrestlerAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'federation_id' => ['required', 'exists:federations,id'],
            'is_active' => ['required', 'boolean'],
        ]);
    
        Wrestler::create($wrestlerAttributes);
    
        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiunto con successo.');
    }


}
