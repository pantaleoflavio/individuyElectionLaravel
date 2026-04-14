<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RankingType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRankingRequest;
use App\Http\Requests\UpdateRankingRequest;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;

class RankingManagementController extends Controller
{
    public function index()
    {
        $rankings = Ranking::with(['category', 'federation'])->get();
        $categories = Category::all();
        $federations = Federation::all();

        return view('admin.ranking', compact('rankings', 'categories', 'federations'));
    }

    public function store(StoreRankingRequest $request)
    {
        Ranking::create($request->validated());

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiunto con successo.');
    }

    public function edit($id)
    {
        $ranking = Ranking::findOrFail($id);
        $categories = Category::all();
        $federations = Federation::all();

        return view('admin.edit-ranking', compact('ranking', 'categories', 'federations'));
    }

    public function update(UpdateRankingRequest $request, $id)
    {
        $ranking = Ranking::findOrFail($id);
        $ranking->update($request->validated());

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiornato con successo.');
    }

    public function destroy($id)
    {
        $ranking = Ranking::findOrFail($id);
        $ranking->delete();

        return redirect()->route('admin.ranking')->with('success', 'Ranking eliminato con successo');
    }
}
