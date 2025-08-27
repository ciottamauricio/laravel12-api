<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // For API requests, don't redirect - let it return 401
        if ($request->expectsJson()) {
            return null;
        }
        
        return route('login'); // Only for web routes
    }
}