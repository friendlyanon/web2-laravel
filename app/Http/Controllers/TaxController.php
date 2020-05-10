<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use App\Tax;

class TaxController extends SubResourceController
{
    protected $model = Tax::class;

    protected $request = TaxRequest::class;
}
