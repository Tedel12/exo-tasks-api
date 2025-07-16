<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();
        // On va si l'utilisateur est authentifié et s'il est un manager
        if ($user && $user->role === $role) {
            return $next($request);
        }
        // Si l'utilisateur n'est pas un manager, on retourne une erreur 403
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
