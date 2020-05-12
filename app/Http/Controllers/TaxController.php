<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use App\Tax;
use Illuminate\Foundation\Http\FormRequest;

class TaxController extends SubResourceController
{
    protected $model = Tax::class;

    protected function validatedRequest(): FormRequest
    {
        return app(TaxRequest::class);
    }
}
