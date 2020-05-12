<?php

namespace App\Http\Requests;

class OrganizationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:organizations',
            'fax' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'swift' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'users' => 'string',
        ];
    }
}
