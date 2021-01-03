<?php



namespace App\Http\Middleware;



use Closure;



class HttpsProtocol {



    public function handle($request, Closure $next)
    {

        if (!$request->secure() && $request->ip() !== '127.0.0.1' && $request->server('SERVER_ADDR') !== '159.89.20.167') {

            return redirect()->secure($request->getRequestUri());

        }



        return $next($request);
    }

}

