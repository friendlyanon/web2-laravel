<?php

namespace App\Http\Requests;

class DiscountRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount' => 'required|numeric|min:0|max:99.99',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
        ];
    }
}
