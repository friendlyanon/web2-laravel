<?php

namespace App\Http\Requests;

class PartnerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
        ];
    }
}
