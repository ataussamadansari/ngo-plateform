<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Display the administrative login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isSuperAdmin() || $user->isManager()) {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('admin.auth.login');
    }

    /**
     * Authenticate administrative user credentials and establish session.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Enforce active account status
            if (! $user->is_active) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your administrative account is inactive. Please contact the super administrator.',
                ])->onlyInput('email');
            }

            // Enforce administrative role (super_admin or manager)
            if (! $user->isSuperAdmin() && ! $user->isManager()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Access denied. Administrative privileges are required to access this portal.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, '.$user->name.'!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our administrative records.',
        ])->onlyInput('email');
    }

    /**
     * Terminate the administrative session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been safely signed out of the back-office.');
    }
}
