<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class TokenApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($user = User::whereToken($request->header('token'))->first()) {

            if ($user->banned == 1) {
                switch ($user->bans_reason) {
                    case User::BANS['spam']:
                        return response()->json(null, 445);
                        break;
                    case User::BANS['balance_cheat']:
                        return response()->json(null, 446);
                        break;
                    case User::BANS['referral_cheat']:
                        return response()->json(null, 447);
                        break;
                    case User::BANS['violation_of_rules']:
                        return response()->json(null, 448);
                        break;
                }

            }

            return $next($request);
        } else {

            return response()->json([
                'error' => 'wrong token'
            ], 401);
        }
    }
}
