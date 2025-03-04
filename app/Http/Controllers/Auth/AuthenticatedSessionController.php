<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user using the 'web' guard
        $request->authenticate('web');

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect the user to the intended page or the dashboard
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the user from the 'web' guard
        Auth::guard('web')->logout();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the homepage or login page
        return redirect('/');
    }
}
