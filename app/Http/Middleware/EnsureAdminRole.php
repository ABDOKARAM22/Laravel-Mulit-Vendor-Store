<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = $request->user('admin');

        if (! $admin) {
            return redirect()->route('admin.login');
        }

        if ($roles !== [] && ! in_array($admin->role, $roles, true)) {
            abort(403);
        }

        if ($admin->isVendor() && ! $admin->store_id) {
            abort(403);
        }

        return $next($request);
    }
}
