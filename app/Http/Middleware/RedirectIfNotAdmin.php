<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next): Response
{
    if (!auth()->guard('admin')->check()) {
        return redirect()->route('admin.login');
    }

    return $next($request);
}
}
