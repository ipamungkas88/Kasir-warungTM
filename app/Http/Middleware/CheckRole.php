<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userRole = auth()->user()->role;
        
        if (!in_array($userRole, $roles)) {
            // Redirect to appropriate dashboard instead of showing 403
            if ($userRole === 'owner') {
                return redirect()->route('owner.dashboard');
            } else {
                return redirect()->route('kasir.dashboard');
            }
        }

        return $next($request);
    }
}
