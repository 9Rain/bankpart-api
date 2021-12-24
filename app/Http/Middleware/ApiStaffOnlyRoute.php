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
        $userRole = auth('api')->user()->user_role_id;

        if ($userRole > 1) {
            return response()->json(['error' => 'Forbbiden'], 403);
        }

        return $next($request);
    }
}
