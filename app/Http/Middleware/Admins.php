<?php

namespace App\Http\Middleware;

use Auth;

class Admins
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
        if (Auth::user()->hasRole('user')) {
            return redirect('/restricted');
        }

        return $next($request);
    }
}
