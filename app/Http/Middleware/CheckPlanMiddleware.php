<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $university = app('current_university');

        if ($university->plan !== 'pro') {
            return redirect()
                ->back()
                ->with('error', 'This feature requires the Pro Plan. Please upgrade to access it.');
        }

        return $next($request);
    }
}
