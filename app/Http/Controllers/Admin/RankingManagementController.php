<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RankingType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingManagementController extends Controller
{
    public function index()
    {
        $rankings = Ranking::all();
        $categories = Category::all();
        return view('admin.ranking', compact('rankings', 'categories'));
    }

    public function store(Request $request)
    {
        $rankingAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:' . implode(',', RankingType::values())],
            'status' => ['required', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'includes_inactive' => ['nullable', 'boolean'],
        ]);

        Ranking::create($rankingAttributes);

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiunto con successo.');
    }

    public function edit($id)
    {
        $ranking = Ranking::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-ranking', compact('ranking', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $ranking = Ranking::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name,' . $ranking->id],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
        ]);

        $ranking->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiornato con successo.');
    }

    public function destroy($id)
    {
        $ranking = Ranking::findOrFail($id);
        $ranking->delete();

        return redirect()->route('admin.ranking')->with('success', 'Ranking eliminato con successo');
    }
}