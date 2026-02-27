<?php

namespace App\Http\Middleware;

use App\Models\University;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('university');

        $university = University::where('slug', $slug)->firstOrFail();

        if (! $university->is_active) {
            abort(403, 'This university account is inactive.');
        }

        if (! auth()->user()->hasRole('super-admin') && auth()->user()->university_id !== $university->id) {
            abort(403, 'You do not have access to this university.');
        }

        app()->instance('current_university', $university);

        return $next($request);
    }
}
