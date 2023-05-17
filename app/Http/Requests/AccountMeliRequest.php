<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountMeliRequest extends FormRequest
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
            'name' => 'required',
            'url' => 'required',
            'store' => 'required',
            'company' => 'required',
            'app_id' => 'required',
            'access_token' => 'required',
            'refresh_token' => 'required',
            'secret_key' => 'required',
            'url_redirect' => 'required'
        ];
    }
}
