<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRol;
use Symfony\Component\HttpFoundation\Response;

class FilamentOnlyAdminParametros
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está autenticado, dejar que Authenticate lo maneje
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Buscar el registro de rol del usuario
        $userRol = UserRol::where('id_user', $user->id)
            ->where('estado', 1)
            ->first();

        // Validar si existe un registro y si el rol es 2 (Admin Parámetros)
        if (!$userRol || (int) $userRol->id_rol !== 2) {
            abort(403, 'No tienes permiso para acceder al panel de administración de parámetros.');
        }

        return $next($request);
    }
}
