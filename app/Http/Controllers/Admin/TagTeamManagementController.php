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
        $tagTeams = TagTeam::with(['category', 'federation'])->get();

        return view('admin.tag_team', compact('tagTeams'));
    }

    public function create()
    {
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();
        return view('admin.add-tag_team', compact('federations', 'categories'));
    }

    public function store(StoreTagTeamRequest $request)
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

    public function edit($id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();

        return view('admin.edit-tag_team', compact('tagTeam', 'federations', 'categories'));
    }

    public function update(UpdateTagTeamRequest $request, $id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $tagTeam->update($request->validated());

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team aggiornato con successo');
    }

    public function destroy($id)
    {
        $tagTeam = TagTeam::findOrFail($id);
        $tagTeam->delete();

        return redirect()->route('admin.tag_team')->with('success', 'Tag Team eliminato con successo');
    }
}