<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\HasParticipantFormOptions;
use App\Http\Requests\StoreWrestlerRequest;
use App\Http\Requests\UpdateWrestlerRequest;
use App\Models\Wrestler;

class WrestlerManagementController extends Controller
{
    use HasParticipantFormOptions;
    

    public function index()
    {
        $wrestlers = Wrestler::with(['categories', 'federations', 'category', 'federation'])->get();

        return view('admin.wrestler', compact('wrestlers'));
    }

    public function create()
    {
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();
        return view('admin.add-wrestler', compact('federations', 'categories'));
    }

    public function store(StoreWrestlerRequest $request)
    {
        $validated = $request->validated();

        $wrestler = Wrestler::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'] ?? null,
            'country' => $validated['country'],
            'category_id' => $validated['category_ids'][0],
            'federation_id' => $validated['federation_ids'][0],
            'is_active' => $validated['is_active'],
        ]);

        $wrestler->categories()->sync($validated['category_ids']);
        $wrestler->federations()->sync($validated['federation_ids']);

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiunto con successo.');
    }

    public function edit($id)
    {
        $wrestler = Wrestler::with(['categories', 'federations'])->findOrFail($id);
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();

        return view('admin.edit-wrestler', compact('wrestler', 'federations', 'categories'));
    }

    public function update(UpdateWrestlerRequest $request, $id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $validated = $request->validated();

        $wrestler->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'] ?? null,
            'country' => $validated['country'],
            'category_id' => $validated['category_ids'][0],
            'federation_id' => $validated['federation_ids'][0],
            'is_active' => $validated['is_active'],
        ]);

        $wrestler->categories()->sync($validated['category_ids']);
        $wrestler->federations()->sync($validated['federation_ids']);

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiornato con successo');
    }

    public function destroy($id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->delete();

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler eliminato con successo');
    }
}
