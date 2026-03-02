<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('admin.users', compact('users'));
    }

    public function promote($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Questo utente è già un amministratore.');
        }

        $user->update(['role' => 'admin']);

        return redirect()->route('admin.users')->with('success', 'Utente promosso a admin con successo.');
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);

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

        if (Auth::id() == $id) {
            return redirect()->route('admin.users')->with('error', 'Non puoi eliminare te stesso.');
        }

        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Non puoi eliminare un Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utente eliminato con successo.');
    }
}