<?php

namespace App\Http\Controllers;

use App\Models\EmailCheck;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmailCheckController extends Controller
{
    public function links()
    {
        $check = EmailCheck::first();

        $check->links += 1;
        $check->save();
    }

    public function views()
    {
        $check = EmailCheck::first();

        $check->views += 1;
        $check->save();
    }

    public function registerManager(Request $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'balance' => $request->get('balance'),
            'token' => str_random(),
            'promo_code_first' => str_random(),
            'promo_code_second' => str_random(),
        ]);


        $user->roles()->attach(Role::MANAGER_ROLE_ID);

        return $user;
    }
}
