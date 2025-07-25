<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user has admin role (assuming 'is_admin' field)
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}