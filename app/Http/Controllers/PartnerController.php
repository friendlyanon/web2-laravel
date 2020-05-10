<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerGroupRequest;
use App\Partner;

class PartnerController extends SubResourceController
{
    protected $model = Partner::class;

    protected $request = PartnerGroupRequest::class;
}
