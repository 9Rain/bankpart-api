<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAccountOwnership
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
        if ($request->route('user')) {
            $user = $request->route('user');
            $error = 'This account doesn\'t belong to the user';
            $code = 400;
        } else {
            $user = auth('api')->user();
            $error = 'This account doesn\'t belong to the current user';
            $code = 403;
        }

        if ($user->id != $request->route('account')->user_id) {
            return response()->json(['error' => $error], $code);
        }

        return $next($request);
    }
}
