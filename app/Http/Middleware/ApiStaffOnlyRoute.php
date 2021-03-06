<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiStaffOnlyRoute
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
        if (!auth('api')->user()->isFromStaff()) {
            return response()->json(['error' => 'Forbbiden'], 403);
        }

        return $next($request);
    }
}
