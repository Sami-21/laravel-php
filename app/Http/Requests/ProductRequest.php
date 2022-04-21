<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'regex:/[a-zA-Z0-9\s]+/|required',
            'quantity' =>'numeric|required | gte:0',
            'price' => 'numeric | gte:0.1|required',
            'store' => 'regex:/[a-zA-Z0-9\s]+/ | required',
        ];
    }
}