<?php

namespace App\Http\Requests;

class ProductRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'tariff' => 'required|numeric|min:0',
            'name' => 'required|string',
            'net_price' => 'required|numeric|min:0|max:999999.99',
        ];
    }
}
