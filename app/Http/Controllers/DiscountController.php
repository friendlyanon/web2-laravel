<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Http\Requests\DiscountRequest;
use Illuminate\Foundation\Http\FormRequest;

class DiscountController extends SubResourceController
{
    protected $model = Discount::class;

    protected function validatedRequest(): FormRequest
    {
        return app(DiscountRequest::class);
    }
}
