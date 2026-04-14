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
        $wrestlers = Wrestler::with(['category', 'federation'])->get();

        return view('admin.wrestler', compact('wrestlers'));
    }

    public function create()
    {
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();
        return view('admin.add-wrestler', compact('federations', 'categories'));
    }

    public function store(StoreWrestlerRequest $request)
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

    public function edit($id)
    {
        $wrestler = Wrestler::findOrFail($id);
        ['federations' => $federations, 'categories' => $categories] = $this->getParticipantFormOptions();

        return view('admin.edit-wrestler', compact('wrestler', 'federations', 'categories'));
    }

    public function update(UpdateWrestlerRequest $request, $id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->update($request->validated());

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiornato con successo');
    }

    public function destroy($id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->delete();

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler eliminato con successo');
    }
}