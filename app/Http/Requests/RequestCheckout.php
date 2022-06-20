<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCheckout extends FormRequest
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
        'email.required' => 'Email is required',
        'first_name.required' => 'First Name is required',
        'last_name.required' => 'Last Name is required',
        'company_name.required' => 'Company Name is required',
        'address.required' => 'Address is required',
        'city.required' => 'City is required',
        'country.required' => 'Country is required',
        'phone.required' => 'Phone is required',
        'terms.required' => 'Term and Conditions must be checked',
        'postcode.required' => 'Post Code is required',
        ];
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'terms' => 'required',
            'postcode' => 'required'
        ];
    }
}
