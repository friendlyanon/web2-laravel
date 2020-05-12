<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerGroupRequest;
use App\PartnerGroup;
use Illuminate\Foundation\Http\FormRequest;

class PartnerGroupController extends SubResourceController
{
    protected $model = PartnerGroup::class;

    protected function validatedRequest(): FormRequest
    {
        return app(PartnerGroupRequest::class);
    }
}
