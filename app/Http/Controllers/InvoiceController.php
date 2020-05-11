<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use Lang;
use RuntimeException;

class InvoiceController extends SubResourceController
{
    protected $model = Invoice::class;

    protected $request = InvoiceRequest::class;

    /** @param Invoice $model */
    protected function validateEditable($model)
    {
        if ($model->status !== Invoice::STATUS_OPEN) {
            throw new RuntimeException(Lang::get('error.invoices.editable'));
        }
    }
}
