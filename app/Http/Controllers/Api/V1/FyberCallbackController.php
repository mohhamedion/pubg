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

class FyberCallbackController extends Controller
{
    private const SECURITY_TOKEN = '';

    public function endpoint(Request $request)
    {
        if (!$this->sid($request))
        {
            $code = 200;
            $mesage = "Bad sid. Callback rejected.";
        }else{
            $user = User::whereEmail($request->get('pub0'))->get()->first();
            $user->balance += $request->get('amount');
            $user->save();

            $code = 200;
            $mesage = "Callback Successful.";
        }

        return response()->json($mesage,$code);
    }

    private function sid(Request $request)
    {
        $string = self::SECURITY_TOKEN;
        if (!empty($request->query('uid'))){
            $string .= $request->query('uid');
        }
        if (!empty($request->query('amount'))){
            $string .= $request->query('amount');
        }
        if (!empty($request->query('_trans_id_'))){
            $string .= $request->query('_trans_id_');
        }
        if (!empty($request->query('pub0'))){
            $string .= $request->query('pub0');
        }

        return (sha1($string) == $request->get('sid'));
    }
}
