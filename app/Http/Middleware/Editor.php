<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Flash;

class Editor
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('editor')) {
            Flash::error(trans('messages.access_denied'));

            return redirect('/');
        }

        return $next($request);
    }
}
