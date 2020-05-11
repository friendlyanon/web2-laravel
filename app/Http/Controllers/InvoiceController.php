<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use Illuminate\Support\LazyCollection;
use Lang;
use Redirect;
use RuntimeException;

class InvoiceController extends SubResourceController
{
    protected $model = Invoice::class;

    protected $request = InvoiceRequest::class;

    public function indexStatus($organization, $status)
    {
        /** @var LazyCollection|Invoice[] $items */
        $items = $this->builder($organization)->where('status', $status)
            ->cursor();

        return view('itemlist', compact('items'));
    }

    public function updateStatus($organization, $invoice, $status)
    {
        /** @var Invoice $model */
        $model = $this->builder($organization)->findOrFail($invoice);
        $model->status = $status;
        $redirect = Redirect::back();

        return $model->save()
            ? $redirect->with('updated', true)
            : $redirect->withErrors(Lang::get('error.invoices.update'));
    }

    /** @param Invoice $model */
    protected function validateEditable($model)
    {
        if ($model->status !== Invoice::STATUS_OPEN) {
            throw new RuntimeException(Lang::get('error.invoices.editable'));
        }
    }
}
