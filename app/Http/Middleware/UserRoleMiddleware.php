<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        if(Auth::check() && Auth::user()->role == $role){
            return $next($request);
        }

        // Si es una petición AJAX, devolver JSON
        if ($request->expectsJson()) {
            return response()->json(['error' => 'You do not have permission to access for this page'], 403);
        }

        // Para peticiones normales del navegador, redirigir con mensaje de error
        return redirect()->back()->with('error', 'No tienes permisos para acceder a esta página.');
    }
}
