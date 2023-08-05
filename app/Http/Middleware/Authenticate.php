<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson() && $request->wantsJson()) {
            return null;
        }

        if ($request->is('api/*')) {
            abort(403);
        }

        return route('filament.auth.login');
    }
}
