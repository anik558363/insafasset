<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MenuPermission;

class MenuPermissionMiddleware
{
    /**
     * Usage: ->middleware('menu:properties')
     */
    public function handle(Request $request, Closure $next, string $menuKey): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admins always pass
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->canAccessMenu($menuKey)) {
            abort(403, 'You do not have permission to access this section.');
        }

        return $next($request);
    }
}
