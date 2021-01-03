<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 18.12.18
 * Time: 16:34
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OfferToroCallbackController extends Controller
{
    private const SECURITY_TOKEN = '';

    public function endpoint(Request $request)
    {
        if (!$this->sig($request))
        {
            $code = 200;
            $mesage = 0;
        }else{
            $user = User::where('token', $request->query('user_id'))->first();
            $user->balance += $request->query('amount');
            $user->save();

            $code = 200;
            $mesage = 1;
        }

        return response()->json($mesage, $code);
    }

    private function sig(Request $request)
    {
        $string = self::SECURITY_TOKEN;
        if (!empty($request->query('oid'))){
            $string .= $request->query('oid') . '-';
        }
        if (!empty($request->query('user_id'))){
            $string .= $request->query('user_id') . '-';
        }
        $string .= env('OFFER_TORO_SECURITY_TOKEN');

        return (md5($string) == $request->query('sig'));
    }
}
