<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Consenti l'accesso solo agli utenti con ruolo 'admin' o 'super_admin'
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            return $next($request);
        }
        
        // Reindirizza o mostra un messaggio se l'utente non è autorizzato
        return redirect()->route('home')->with('error', 'Accesso non autorizzato.');
    }
}
