<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductController extends SubResourceController
{
    protected $model = Product::class;

    protected function validatedRequest(): FormRequest
    {
        return app(ProductRequest::class);
    }
}
