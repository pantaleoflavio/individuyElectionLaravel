<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create ()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Email o password errati, riprova grazie.'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/')->with('success', 'Login effettuato con successo.');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
