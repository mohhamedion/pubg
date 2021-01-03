<?php

namespace App\Http\Requests;

use App\Models\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role === Role::ADMIN_ROLE_ID;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'preview' => 'required|max:255',
            'body' => 'required',
        ];
    }
}
