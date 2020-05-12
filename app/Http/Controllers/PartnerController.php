<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerRequest;
use App\Partner;
use Illuminate\Foundation\Http\FormRequest;

class PartnerController extends SubResourceController
{
    protected $model = Partner::class;

    protected function validatedRequest(): FormRequest
    {
        return app(PartnerRequest::class);
    }
}
