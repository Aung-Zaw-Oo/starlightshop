<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = session('role');

        if (!session()->has('staff_id') || !in_array($role, ['Admin', 'Manager', 'Staff'])) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized user');
        }

        return $next($request);
    }
}
