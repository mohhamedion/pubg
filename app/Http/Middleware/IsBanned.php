<?php

namespace App\Http\Middleware;

use Auth;

class IsBanned
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (Auth::user()->banned) {
            return redirect('/banned');
        }

        return $next($request);
    }
}
