<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Invoice;

class InvoiceController extends SubResourceController
{
    protected $model = Invoice::class;

    protected $request = InvoiceRequest::class;
}
