<?php

namespace App;

use App\Utils\HasEditCheck;
use App\Utils\HasTableHeaders;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends BaseModel
{
    use SoftDeletes;
    use HasTableHeaders;
    use HasEditCheck;
}
