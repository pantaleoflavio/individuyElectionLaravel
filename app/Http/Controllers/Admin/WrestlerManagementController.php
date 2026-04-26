<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\HasParticipantFormOptions;
use App\Http\Requests\StoreWrestlerRequest;
use App\Http\Requests\UpdateWrestlerRequest;
use App\Models\Wrestler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WrestlerManagementController extends Controller
{
    use HasParticipantFormOptions;
    

    public function index()
    {
        $wrestlers = Wrestler::with(['categories', 'federations'])->get();

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

        try {
            DB::transaction(function () use ($validated): void {
                $wrestler = Wrestler::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'image_url' => $validated['image_url'] ?? null,
                    'country' => $validated['country'],
                    'is_active' => $validated['is_active'],
                ]);

                $wrestler->categories()->sync($validated['category_ids']);
                $wrestler->federations()->sync($validated['federation_ids']);
            });
        } catch (\Throwable $exception) {
            Log::error('Errore durante il salvataggio del Wrestler.', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Impossibile salvare il Wrestler.');
        }

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

        try {
            DB::transaction(function () use ($wrestler, $validated): void {
                $wrestler->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'image_url' => $validated['image_url'] ?? null,
                    'country' => $validated['country'],
                    'is_active' => $validated['is_active'],
                ]);

                $wrestler->categories()->sync($validated['category_ids']);
                $wrestler->federations()->sync($validated['federation_ids']);
            });
        } catch (\Throwable $exception) {
            Log::error('Errore durante l\'aggiornamento del Wrestler.', [
                'wrestler_id' => $wrestler->id,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Impossibile aggiornare il Wrestler. Controlla i log applicativi.');
        }

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler aggiornato con successo');
    }

    public function destroy($id)
    {
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->delete();

        return redirect()->route('admin.wrestler')->with('success', 'Wrestler eliminato con successo');
    }
}
