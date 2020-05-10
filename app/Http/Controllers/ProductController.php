<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;

class ProductController extends SubResourceController
{
    protected $model = Product::class;

    protected $request = ProductRequest::class;
}
