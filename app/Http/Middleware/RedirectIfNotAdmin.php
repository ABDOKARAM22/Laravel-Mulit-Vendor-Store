<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user('admin')) {
            return redirect()->route('admin.login');
        }

        Auth::shouldUse('admin');

        return $next($request);
    }
}
