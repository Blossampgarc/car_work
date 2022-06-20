<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCart extends FormRequest
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
    public function messages()
    {
        return [
        'price.required' => 'Price is required',  
        'quantity.required' => 'Quantity is required'
        ];
    }

    public function rules()
    {
        return [
            'price' => 'required',
            'quantity' => 'required'

        ];
    }
}
