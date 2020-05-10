<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\LazyCollection;
use Lang;
use Redirect;
use Str;

abstract class SubResourceController extends Controller
{
    protected $middleware = ['auth'];

    /** @var string */
    protected $model;

    /** @var string */
    protected $request;

    /** @var string */
    private $plural;

    public function __construct()
    {
        parent::__construct();

        $this->plural = Str::plural(Str::snake(class_basename($this->model)));
    }

    public function index($organization)
    {
        /** @var LazyCollection|Model[] $items */
        $items = $this->builder($organization)->cursor();

        return view('itemlist', compact('items'));
    }

    public function create($organization)
    {
        return view("$this->plural.create", compact('organization'));
    }

    public function store($organization)
    {
        $request = $this->validatedRequest();
        /** @var HasMany $relation */
        $relation = $this->builder($organization)->{$this->plural}();
        $model = new ($this->model)($request->all());

        if ($relation->save($model)) {
            return Redirect
                ::route("$this->plural.index", compact('organization'))
                ->with('created', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get("error.$this->plural.store"))
            ->withInput($request->input());
    }

    public function show($organization, $id)
    {
        $model = $this->builder($organization)->findOrFail($id);

        return view("$this->plural.show", [$this->model => $model]);
    }

    public function edit($organization, $id)
    {
        $model = $this->builder($organization)->findOrFail($id);

        return view("$this->plural.show", [$this->model => $model]);
    }

    public function update($organization, $id)
    {
        $request = $this->validatedRequest();
        /** @var HasMany $relation */
        $relation = $this->builder($organization)->{$this->plural}();
        $model = $relation->findOrFail($id);
        $model->fill($request->all());

        if ($model->save()) {
            return Redirect::route("$this->plural.show", [
                'organization' => $organization,
                $this->model => $model,
            ])->with('updated', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get("error.$this->plural.update"))
            ->withInput($request->input());
    }

    public function destroy($organization, $id)
    {
        $count = $this->builder($organization)->toBase()->delete($id);

        if ($count !== 0) {
            return Redirect::route("$this->plural.index")
                ->with('deleted', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get("error.$this->plural.destroy"));
    }

    private function validatedRequest(): FormRequest
    {
        /** @var FormRequest $request */
        $request = ("$this->request::createFrom")(FormRequest::capture());
        $request->validateResolved();
        return $request;
    }

    private function builder($organization = null): Builder
    {
        return $this->organizations->where('id', $organization)
            ->{$this->plural}();
    }
}
