<?php

namespace App\Http\Requests;

use Auth;

class UserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route_name = $this->route()->getName();

        switch ($route_name) {
            case 'account::patch.index':
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id,
                ];
                break;
            default:
                // Register
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'required|confirmed|min:6',
                ];
                break;
        }

        return $rules;
    }
}
