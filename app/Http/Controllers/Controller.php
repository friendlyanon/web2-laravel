<?php

namespace App\Http\Controllers;

use App\Organization;
use App\User;
use Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    private const FILLER = [null, null];

    /** @var User */
    protected $user;

    /** @var Builder|Organization[]|Organization */
    protected $organizations;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();
            $this->organizations = $this->user->is_admin
                ? Organization::query()
                : $this->user->organizations();

            return $next($request);
        });
    }

    public function getMiddleware()
    {
        return array_map(self::class . '::parseMiddleware', $this->middleware);
    }

    protected function attachAll(
        Model $model,
        FormRequest $request,
        string $name
    ) {
        /** @var BelongsToMany $relation */
        $relation = $model->{$name}();
        foreach ($request->get($name, []) as $id) {
            $relation->attach($id);
        }
    }

    protected function reattachAll(
        Model $model,
        FormRequest $request,
        string $name
    ) {
        $model->{$name}()->detach();
        $this->attachAll($model, $request, $name);
    }

    public static function parseMiddleware($middleware): array
    {
        if (! \is_string($middleware)) {
            return $middleware;
        }

        [$middleware, $rest] =
            array_replace(self::FILLER, explode('|', $middleware, 2));
        $options = iterator_to_array(self::buildOptions($rest));
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
