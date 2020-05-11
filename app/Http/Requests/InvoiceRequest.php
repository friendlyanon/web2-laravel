<?php

namespace App\Http\Requests;

class InvoiceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:0',
            'is_closed' => 'required|boolean',
        ];
    }
}
