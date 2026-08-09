<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only admin, agent, employee roles can access admin panel
        if (!in_array($user->role, ['admin', 'agent', 'employee'])) {
            abort(403, 'Access denied. Insufficient privileges.');
        }

        // Deactivated users cannot access the admin panel
        if (isset($user->is_active) && !$user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact an administrator.');
        }

        return $next($request);
    }
}
