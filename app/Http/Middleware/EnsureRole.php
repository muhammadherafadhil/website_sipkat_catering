<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if (!$user) abort(401);

        // OOP: POLYMORPHISM via method isAdmin()/isCustomer()
        foreach ($roles as $role) {
            $method = 'is' . ucfirst($role);
            if (method_exists($user, $method) && $user->{$method}()) {
                return $next($request);
            }
        }
        abort(403, 'Akses ditolak.');
    }
}