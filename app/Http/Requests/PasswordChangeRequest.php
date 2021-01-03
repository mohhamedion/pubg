<?php

namespace App\Http\Requests;

use Auth;

class PasswordChangeRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();

        return [
            'password' => 'old_password:' . $user->password,
            'new_password' => 'required|min:6|confirmed'
        ];
    }
}
