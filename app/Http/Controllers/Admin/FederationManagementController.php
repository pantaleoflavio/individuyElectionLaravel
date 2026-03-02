<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Federation;
use Illuminate\Http\Request;

class FederationManagementController extends Controller
{
    public function index()
    {
        $federations = Federation::all();
        return view('admin.federation', compact('federations'));
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
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