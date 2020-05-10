<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerGroupRequest;
use App\PartnerGroup;

class PartnerGroupController extends SubResourceController
{
    protected $model = PartnerGroup::class;

    protected $request = PartnerGroupRequest::class;
}
