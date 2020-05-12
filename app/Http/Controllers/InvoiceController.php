<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\LazyCollection;
use Lang;
use Redirect;

class InvoiceController extends SubResourceController
{
    protected $model = Invoice::class;

    public function indexStatus($organization, $status)
    {
        /** @var LazyCollection|Invoice[] $items */
        $items = $this->builder($organization)->where('status', $status)
            ->cursor();
        $headers = Invoice::getHeaders();
        $canModify = false;

        return view('itemlist', compact('items', 'headers', 'canModify'));
    }

    public function updateStatus($organization, $invoice, $status)
    {
        /** @var Invoice $model */
        $model = $this->builder($organization)->findOrFail($invoice);
        $model->status = $status;
        $redirect = Redirect::back();

        return $model->save()
            ? $redirect->with('updated', true)
            : $redirect->withErrors(['error' => Lang::get('error.invoices.update')]);
    }

    /** @param Invoice $model */
    protected function validateEditable($model)
    {
        if ($model->canBeEdited()) {
            return;
        }

        $error = Lang::get('error.invoices.editable');
        abort(Redirect::back()->withErrors(compact('error')));
    }

    protected function validatedRequest(): FormRequest
    {
        return app(InvoiceRequest::class);
    }
}
