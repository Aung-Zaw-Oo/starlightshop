<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('customer_id')) {
            // Save intended URL to redirect after login
            return redirect()->route('customer.loginForm')->with([
                'redirectTo' => url()->current(),
                'error' => 'You need to login first.'
            ]);
        }
        return $next($request);
    }
}
