<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'regex:/[a-zA-Z\s]+/|required',
            'email' => 'email|required',
            'phone' => 'numeric|required',
            'address' => 'regex:/[a-zA-Z0-9\s]+/|required',
        ];
    }
}
