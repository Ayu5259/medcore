<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $roles
    ): Response {
        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403);
        }

        $allowedRoles = array_map(
            'strtolower',
            array_map('trim', explode(',', $roles))
        );

        $userRole = strtolower($user->role->name);

        if (!in_array($userRole, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
