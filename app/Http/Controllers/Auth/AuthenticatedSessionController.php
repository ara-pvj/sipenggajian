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
    $request->authenticate();

    $request->session()->regenerate();

    $user = auth()->user();

    if ($user->role == 'bendahara') {
        return redirect()->route('dashboard.bendahara');
    }

    if ($user->role == 'tata_usaha') {
        return redirect()->route('dashboard.tatausaha');
    }

    if ($user->role == 'kurikulum') {
        return redirect()->route('dashboard.kurikulum');
    }

    if ($user->role == 'guru') {
        return redirect()->route('dashboard.guru');
    }

    if ($user->role == 'staff') {
        return redirect()->route('dashboard.guru');
    }

    if ($user->role == 'kepala_sekolah') {
        return redirect()->route('dashboard.kepala');
    }

    return redirect('/');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
