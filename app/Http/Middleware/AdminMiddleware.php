<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRol;
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
        // 🔧 ID del rol Administrador = 1
        $rolId = 1;

        if (!Auth::check()) {
            return redirect('/login');
        }

        $idUser = Auth::id();

        // 🔍 Verifica si el usuario tiene el rol de Administrador
        $tieneRol = UserRol::where('id_user', $idUser)
            ->where('id_rol', $rolId)
            ->where('estado', 1)
            ->exists();

        if (!$tieneRol) {
            abort(403, 'Acceso denegado. Se requiere rol de Administrador.');
        }

        return $next($request);
    }
}
