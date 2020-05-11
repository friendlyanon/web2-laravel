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
    /** @var string */
    protected $model;

    /** @var string */
    protected $request;

    /** @var string */
    private $singular;

    /** @var string */
    private $plural;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->singular = Str::snake(class_basename($this->model));
        $this->plural = Str::plural($this->singular);
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
        $class = $this->model;
        $request = $this->validatedRequest();
        /** @var HasMany $relation */
        $relation = $this->builder($organization);

        if ($relation->save(new $class($request->all()))) {
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

        return view("$this->plural.show", [$this->singular => $model]);
    }

    public function edit($organization, $id)
    {
        $model = $this->builder($organization)->findOrFail($id);
        $this->validateEditable($model);

        return view("$this->plural.show", [$this->singular => $model]);
    }

    public function update($organization, $id)
    {
        $request = $this->validatedRequest();
        $model = $this->builder($organization)->findOrFail($id);
        $this->validateEditable($model);
        $model->fill($request->all());

        if ($model->save()) {
            return Redirect::route("$this->plural.show", [
                'organization' => $organization,
                $this->singular => $model,
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

    protected function validateEditable($model) { }

    protected function validatedRequest(): FormRequest
    {
        return app($this->request);
    }

    protected function builder(int $organization): Builder
    {
        return $this->organizations->where('id', $organization)
            ->{$this->plural}();
    }
}
