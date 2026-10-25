<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        // 1. Enforce Authentication
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('admin.login'))->with('error', 'Please sign in to access the administrative back-office.');
        }

        $user = Auth::user();

        // 2. Enforce Active Status
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Your administrative account has been deactivated.');
        }

        // 3. Enforce Specific Role if provided (e.g. admin.role:super_admin)
        if ($role !== null) {
            if ($user->role !== $role) {
                abort(403, 'Unauthorized action. Specific administrator role required.');
            }

            return $next($request);
        }

        // 4. Enforce General Admin Privileges (super_admin or manager)
        if (! $user->isSuperAdmin() && ! $user->isManager()) {
            abort(403, 'Access denied. Administrative role required.');
        }

        return $next($request);
    }
}
