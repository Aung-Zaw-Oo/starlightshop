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
            // Store intended URL in session for redirect after login
            session()->put('redirectTo', url()->current());
            
            return redirect()->route('customer.loginForm')->with([
                'error' => 'You need to login first.'
            ]);
        }
        return $next($request);
    }
}
