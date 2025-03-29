<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckSucursalSelected
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Verifica si el usuario está autenticado
        if (!Auth::check())
        {
            return redirect()->route('login');
        }

        // 2. Verifica si ha seleccionado una sucursal
        if (!$request->session()->has('id_sucursal') && !$request->is('vista_sucursal')) {
            return redirect()->route('vista_sucursal');
        }
        
        return $next($request);
    }
}
