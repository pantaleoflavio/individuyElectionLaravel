<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFederationRequest;
use App\Http\Requests\UpdateFederationRequest;
use App\Models\Federation;

class FederationManagementController extends Controller
{
    public function index()
    {
        $federations = Federation::all();
        return view('admin.federation', compact('federations'));
    }

    public function store(StoreFederationRequest $request)
    {
        $federationAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:federations,name'],
        ]);

        Federation::create($federationAttributes);

        return redirect()->route('admin.federation')->with('success', 'Federazione aggiunta con successo.');
    }

    public function edit($id)
    {
        $federation = Federation::findOrFail($id);

        return view('admin.edit-federation', compact('federation'));
    }

    public function update(UpdateFederationRequest $request, $id)
    {
        $federation = Federation::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:federations,name,' . $federation->id],
        ]);

        $federation->update($validatedData);

        return redirect()->route('admin.federation.edit', $federation->id)->with('success', 'Federazione aggiornata con successo');
    }

    public function destroy($id)
    {
        $federation = Federation::findOrFail($id);
        $federation->delete();

        return redirect()->route('admin.federation')->with('success', 'Federazione eliminata con successo');
    }
}