<?php

namespace App\Http\Middleware;

use Auth;
use Flash;

class AdminOnly
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!Auth::user()->hasRole('admin')) {
            Flash::error(trans('messages.access_denied'));

            return redirect('/');
        }

        return $next($request);
    }
}
