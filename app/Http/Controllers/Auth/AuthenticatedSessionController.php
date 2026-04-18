<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return response()->view('auth.login')->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $sessionId  = $request->session()->getId();
        $cookieName = config('session.cookie');
        $secure     = config('session.secure') ? ';Secure' : '';
        $home       = RouteServiceProvider::HOME;

        \Log::info('[LOGIN-OK]', [
            'email'      => $request->email,
            'session_id' => $sessionId,
            'user_id'    => \Illuminate\Support\Facades\Auth::id(),
        ]);

        // nginx strips Set-Cookie headers; set the session cookie via JS instead
        $js = "document.cookie='{$cookieName}={$sessionId};path=/;SameSite=Lax{$secure}';window.location='{$home}';";
        return response("<script>{$js}</script>", 200, [
            'Content-Type'  => 'text/html',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
