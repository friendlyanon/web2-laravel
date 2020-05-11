<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Organization;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lang;

class ApiController extends Controller
{
    /** @var Request */
    protected $request;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:access_users')->only('filterUsers');
        $this->middleware(function ($request, $next) {
            $this->request = $request;

            return $next($request);
        });
    }

    public function filterUsers()
    {
        $models = User::query();

        return $this->handleFilter($models);
    }

    public function filterOrganizations()
    {
        $models = $this->organizations;

        return $this->handleFilter($models);
    }

    public function filterResource($organization, $resource)
    {
        $this->validateResource($resource);

        /** @var HasMany $models */
        $models = $this->organizations->where('id', $organization)
            ->{$resource}();

        return $this->handleFilter($models);
    }

    private function handleFilter($models)
    {
        foreach ($this->request as $key => $value) {
            $this->validateKey($models, $key);
            $models->where($key, 'LIKE', $this->makeLikeString($value));
        }

        return response()->json($models->get());
    }

    private function makeLikeString(string $string): string
    {
        $literals = ['\\', '%', '_'];
        $escapes = ['\\\\', '\\%', '\\_'];
        return '%' . str_replace($literals, $escapes, $string) . '%';
    }

    private function validateResource($resource)
    {
        $this->abortIf(! \in_array($resource, Organization::RESOURCES, true));
    }

    /**
     * @param HasMany $relation
     * @param string $key
     */
    private function validateKey($relation, $key)
    {
        $fillable = $relation->getModel()->getFillable();
        $this->abortIf(! \in_array($key, $fillable, true));
    }

    private function abortIf($condition)
    {
        if (! $condition) {
            return;
        }

        $error = Lang::get('error.api.unknown');
        abort(response()->json(compact('error')));
    }
}
