<?php

namespace App\Http\Requests;

class ScreenshotRequest extends Request
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
        return [
            'device_token' => 'required|exists:users,device_token',
            'image' => 'required|image|max:1024', // 1 Mb
            'app_id' => 'required|numeric|min:0',
        ];
    }
}
