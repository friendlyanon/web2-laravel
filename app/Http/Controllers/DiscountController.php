<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Http\Requests\DiscountRequest;

class DiscountController extends SubResourceController
{
    protected $model = Discount::class;

    protected $request = DiscountRequest::class;
}
