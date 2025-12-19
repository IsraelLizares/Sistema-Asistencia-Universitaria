<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRol;
use Symfony\Component\HttpFoundation\Response;

class CoordinadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🔧 IDs permitidos: Admin (1) y Coordinador (4)
        $rolesPermitidos = [1, 4];

        if (!Auth::check()) {
            return redirect('/login');
        }

        $idUser = Auth::id();

        // 🔍 Verifica si el usuario tiene rol de Admin o Coordinador
        $tieneRol = UserRol::where('id_user', $idUser)
            ->whereIn('id_rol', $rolesPermitidos)
            ->where('estado', 1)
            ->exists();

        if (!$tieneRol) {
            abort(403, 'Acceso denegado al módulo de Coordinación.');
        }

        return $next($request);
    }
}
