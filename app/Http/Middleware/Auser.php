<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Auser
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
        if (!Auth::guard('api')->check()) {
            abort(
                response()->json(
                    [
                        'status' => false,
                        'data' => 'Unauthenticated',
                    ],
                    200
                )
            );
        } else {
            $user = Auth::guard('api')->user();
            if($user->is_blocked == 1){
                abort(
                    response()->json(
                        [
                            'status' => false,
                            'data' => 'Unauthenticated',
                        ],
                        200
                    )
                );
            }

            return $next($request);
        }
    }
}
