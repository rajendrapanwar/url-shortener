<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        foreach ($roles as $role) {
            $method = 'is' . str_replace('_', '', ucwords($role, '_'));
            
            if (method_exists($user, $method) && $user->$method()) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}