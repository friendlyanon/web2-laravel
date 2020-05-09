<?php

namespace App\Http\Controllers;

use Generator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    private const FILLER = [null, null];

    public function getMiddleware()
    {
        return array_map(self::class . '::mapMiddleware', $this->middleware);
    }

    public static function mapMiddleware($middleware): array
    {
        if (\is_array($middleware)) {
            return $middleware;
        }

        [$middleware, $rest] =
            array_replace(self::FILLER, explode('|', $middleware, 2));
        $options = iterator_to_array(self::buildOptions($rest), false);
        return compact('middleware', 'options');
    }

    private static function buildOptions(?string $options): Generator
    {
        if ($options === null) {
            return;
        }

        foreach (explode('|', $options) as $string) {
            [$key, $value] =
                array_replace(self::FILLER, explode(':', $string, 2));
            yield $key => explode(',', $value);
        }
    }
}
