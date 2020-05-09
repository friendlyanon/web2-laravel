<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function getMiddleware()
    {
        return array_map(self::class . '::mapMiddleware', $this->middleware);
    }

    public static function mapMiddleware($middleware): array
    {
        if (\is_array($middleware)) {
            return $middleware;
        }

        $options = [];
        return compact('middleware', 'options');
    }
}
