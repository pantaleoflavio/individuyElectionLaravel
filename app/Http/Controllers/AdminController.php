<?php

namespace App\Http\Controllers;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\User;
use App\Models\Wrestler;
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
        $wrestlerRankings = Ranking::where('type', RankingType::Wrestler->value)->withCount('votesWrestler')->get();
        $tagTeamRankings = Ranking::where('type', RankingType::TagTeam->value)->withCount('votesTagTeam')->get();
        
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

    // WRESTLER CRUD

    public function edit_wrestler($id)
    {
        $wrestler = Wrestler::findOrFail($id);
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

    // TAG TEAM CRUD
    
    public function edit_tag_team($id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $federations = Federation::all();
        $categories = Category::all();
        
        return view('admin.edit-tag_team', compact('tagTeam', 'federations', 'categories'));
    }

    public function update_tag_team(Request $request, $id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $tagTeam->update($request->all());
        
        return redirect()->route('admin.tag_team')->with('success', 'Tag Team aggiornato con successo');
    }

    public function delete_tag_team(Request $request, $id)
    {
        
        $tagTeam = TagTeam::findOrFail($id);

        $tagTeam->delete();

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team eliminato con successo');
    }

    public function add_tag_team()
    {
        $federations = Federation::all();
        $categories = Category::all();
        return view('admin.add-tag_team', compact('federations', 'categories'));
    }

    public function store_tag_team(Request $request)
    {
        $tagTeamAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'federation_id' => ['required', 'exists:federations,id'],
            'is_active' => ['required', 'boolean'],
        ]);
    
        TagTeam::create($tagTeamAttributes);
    
        return redirect()->route('admin.tag_team')->with('success', 'Tag Team aggiunto con successo.');
    }

    // CATEGORY CRUD

    public function store_category(Request $request)
    {
        $categoryAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);
    
        Category::create($categoryAttributes);
    
        return redirect()->route('admin.category')->with('success', 'Categoria aggiunta con successo.');
    }    

    public function delete_category(Request $request, $id)
    {
        
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Categoria eliminata con successo');
    }

    public function edit_category($id)
    {
        $category = Category::findOrFail($id);
        
        return view('admin.edit-category', compact('category'));
    }

    public function update_category(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);
    
        $category->update($validatedData);
        
        return redirect()->route('admin.category.edit', $category->id)->with('success', 'Categoria aggiornata con successo');
    }

    // FEDERATION CRUD

    public function store_federation(Request $request)
    {
        $federationAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:federations,name'],
        ]);
    
        Federation::create($federationAttributes);
    
        return redirect()->route('admin.federation')->with('success', 'Federazione aggiunta con successo.');
    }    

    public function delete_federation(Request $request, $id)
    {
        
        $federation = Federation::findOrFail($id);

        $federation->delete();

        return redirect()->route('admin.federation')->with('success', 'Federazione eliminata con successo');
    }

    public function edit_federation($id)
    {
        $federation = Federation::findOrFail($id);
        
        return view('admin.edit-federation', compact('federation'));
    }

    public function update_federation(Request $request, $id)
    {
        $federation = Federation::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:federations,name,' . $federation->id],
        ]);
    
        $federation->update($validatedData);
        
        return redirect()->route('admin.federation.edit', $federation->id)->with('success', 'Federazione aggiornata con successo');
    }

    // RANKING CRUD

    public function store_ranking(Request $request)
    {
        $rankingAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string','in' . implode(',', RankingType::values())],
            'status' => ['required', 'boolean'],
            'category_id' =>  ['nullable', 'exists:categories,id'],
            'includes_inactive' => ['nullable', 'boolean'],
        ]);
    
        Ranking::create($rankingAttributes);
    
        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiunto con successo.');
    }    

    public function delete_ranking(Request $request, $id)
    {
        
        $ranking = Ranking::findOrFail($id);

        $ranking->delete();

        return redirect()->route('admin.ranking')->with('success', 'Ranking eliminato con successo');
    }

    public function edit_ranking($id)
    {
        $ranking = Ranking::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-ranking', compact('ranking', 'categories'));
    }

    public function update_ranking(Request $request, $id)
    {
        $ranking = Ranking::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name,' . $ranking->id],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1']
        ]);
    
        // Aggiorniamo solo name e description - aggiunto status
        $ranking->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);
    
        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiornato con successo.');
    }    

    // USER CRUD

    public function users()
    {
        $users = User::get();
        
        return view('admin.users', compact(
            'users',
        ));
    }

    public function promote($id)
    {
        $user = User::findOrFail($id);

        // Impedisci la promozione di utenti già admin o super admin
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Questo utente è già un amministratore.');
        }

        $user->update(['role' => 'admin']);

        return redirect()->route('admin.users')->with('success', 'Utente promosso a admin con successo.');
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);

        // Impedisci la rimozione del ruolo di super admin o admin principale
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Non puoi rimuovere il ruolo di un Super Admin.');
        }

        if ($user->role !== 'admin') {
            return redirect()->route('admin.users')->with('error', 'Questo utente non è un amministratore.');
        }

        $user->update(['role' => 'user']);

        return redirect()->route('admin.users')->with('success', 'Utente rimosso dal ruolo di admin con successo.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Impedisci l'eliminazione di te stesso o di utenti protetti
        if (auth()->id == $id) {
            return redirect()->route('admin.users')->with('error', 'Non puoi eliminare te stesso.');
        }

        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Non puoi eliminare un Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utente eliminato con successo.');
    }



}
