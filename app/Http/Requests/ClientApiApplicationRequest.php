<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientApiApplicationRequest extends FormRequest
{
    /**
     * Request goes through ClientApi middleware so return true.
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
        $min_limit = Settings::getInstance()->getAttribute('application_downloads_min_limit');

        return [
            'device_type' => [
                'required',
                Rule::in(['android', 'ios']),
            ],
            'package_name' => 'required',
            'limit' => [
                'required',
                'numeric',
                "between:${min_limit},30000",
            ],
            'days' => [
                'required',
                'numeric',
                'between:3,22',
            ],
            'time_delay' => [
                'required',
                Rule::in([86400, 172800]),
            ],
            'description' => '',
            'country_id' => [
                'sometimes',
                Rule::exists('country_', 'id'),
            ],
            'city_id' => [
                'sometimes',
                Rule::exists('city_', 'id'),
            ],
            'keywords' => '',
        ];
    }
}
