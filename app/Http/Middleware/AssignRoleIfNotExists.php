<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
class AssignRoleIfNotExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Verificar si el usuario tiene algún rol asignado
        if ($user && !$user->hasAnyRole(Role::all())) {
            // Asignar el rol con ID 4 si el usuario no tiene roles
            $user->assignRole(4); // O puedes usar Role::find(4)->name para mayor claridad
        }
        return $next($request);
    }
}
