<?php

namespace App\Http\Controllers\Admin;

use App\Traits\HasParticipantFormOptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagTeamRequest;
use App\Http\Requests\UpdateTagTeamRequest;
use App\Models\TagTeam;

class TagTeamManagementController extends Controller
{
    use HasParticipantFormOptions;
    
    public function index()
    {
        $tagTeams = TagTeam::with(['categories', 'federations', 'category', 'federation'])->get();

        return view('admin.tag_team', compact('tagTeams'));
    }

    public function create()
    {
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();
        return view('admin.add-tag_team', compact('federations', 'categories'));
    }

    public function store(StoreTagTeamRequest $request)
    {
        $validated = $request->validated();

        $tagTeam = TagTeam::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'] ?? null,
            'country' => $validated['country'],
            'category_id' => $validated['category_ids'][0],
            'federation_id' => $validated['federation_ids'][0],
            'is_active' => $validated['is_active'],
        ]);

        $tagTeam->categories()->sync($validated['category_ids']);
        $tagTeam->federations()->sync($validated['federation_ids']);

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team aggiunto con successo.');
    }

    public function edit($id)
    {
        $tagTeam = TagTeam::with(['categories', 'federations'])->findOrFail($id);
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();

        return view('admin.edit-tag_team', compact('tagTeam', 'federations', 'categories'));
    }

    public function update(UpdateTagTeamRequest $request, $id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $validated = $request->validated();

        $tagTeam->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'] ?? null,
            'country' => $validated['country'],
            'category_id' => $validated['category_ids'][0],
            'federation_id' => $validated['federation_ids'][0],
            'is_active' => $validated['is_active'],
        ]);

        $tagTeam->categories()->sync($validated['category_ids']);
        $tagTeam->federations()->sync($validated['federation_ids']);

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team aggiornato con successo');
    }

    public function destroy($id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $tagTeam->delete();

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team eliminato con successo');
    }
}