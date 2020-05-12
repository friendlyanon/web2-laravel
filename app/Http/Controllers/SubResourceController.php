<?php

namespace App\Http\Controllers;

use App\Model;
use App\Utils\ForeignHandler;
use App\Utils\Slug;
use Illuminate\Database\Eloquent\Builder;
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
    private $plural;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->plural = Str::plural(Str::snake(class_basename($this->model)));
    }

    public function index($organization)
    {
        /** @var LazyCollection|Model[] $items */
        $items = $this->builder($organization)->cursor();
        /** @var array<string, string> $headers */
        $headers = ("$this->model::getHeaders")();
        /** @var Slug $headers */
        $slug = ("$this->model::getModelSlug")();
        $slug->setOrganization($organization);
        $canModify = true;

        $table = compact('slug', 'items', 'headers', 'canModify');

        return view('itemlist', compact('slug', 'table'));
    }

    public function create($organization)
    {
        $slug = Slug::fromModel($this->model);
        $slug->setOrganization($organization);
        $foreignHandler = new ForeignHandler(
            fn() => $this->builder($organization),
        );

        return view('resources.create', compact('slug', 'foreignHandler'));
    }

    public function store($organization)
    {
        $class = $this->model;
        $request = $this->validatedRequest();
        $relation = $this->builder($organization);

        if ($relation->save(new $class($request->all()))) {
            return Redirect
                ::route("organizations.$this->plural.index", compact('organization'))
                ->with('created', true);
        }

        $error = Lang::get("error.$this->plural.store");
        return Redirect::back()
            ->withErrors(compact('error'))
            ->withInput($request->input());
    }

    public function show($organization, $id)
    {
        $model = $this->builder($organization)->findOrFail($id);
        $slug = Slug::fromModel($this->model);
        $slug->setOrganization($organization);

        return view('resources.show', compact('slug', 'model'));
    }

    public function edit($organization, $id)
    {
        $model = $this->builder($organization)->findOrFail($id);
        $this->validateEditable($model);
        $slug = Slug::fromModel($this->model);
        $slug->setOrganization($organization);

        return view('resources.edit', compact('slug', 'model'));
    }

    public function update($organization, $id)
    {
        $request = $this->validatedRequest();
        $model = $this->builder($organization)->findOrFail($id);
        $this->validateEditable($model);
        $model->fill($request->all());

        if ($model->save()) {
            return Redirect::route(
                "organizations.$this->plural.show",
                compact('organization', 'model'),
            );
        }

        $error = Lang::get("error.$this->plural.update");
        return Redirect::back()
            ->withErrors(compact('error'))
            ->withInput($request->input());
    }

    public function destroy($organization, $id)
    {
        $count = $this->builder($organization)->toBase()->delete($id);

        if ($count !== 0) {
            return Redirect::route(
                "organizations.$this->plural.index",
                compact('organization'),
            );
        }

        $error = Lang::get("error.$this->plural.destroy");
        return Redirect::back()->withErrors(compact('error'));
    }

    protected function validateEditable($model)
    {
        //
    }

    /**
     * @param int $organization
     * @return HasMany
     */
    protected function builder(int $organization)
    {
        $relation = Str::camel($this->plural);
        return $this->organizations->findOrFail($organization)
            ->{$relation}();
    }

    abstract protected function validatedRequest(): FormRequest;
}
