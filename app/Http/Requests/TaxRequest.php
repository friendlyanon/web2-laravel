<?php

namespace App\Http\Requests;

class TaxRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tax' => 'required|numeric|min:0|max:99.99',
        ];
    }
}
