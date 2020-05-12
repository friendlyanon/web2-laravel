<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Organization;
use App\User;
use App\Utils\ForeignHandler;
use App\Utils\Slug;
use Lang;
use Redirect;

class OrganizationController extends Controller
{
    protected $middleware = [
        'auth',
        'can:manage_organizations|only:create,store,destroy',
    ];

    public function index()
    {
        $items = $this->organizations->cursor();
        $headers = Organization::getHeaders();
        $slug = Organization::getModelSlug();
        $canModify = $this->user->is_admin;

        $table = compact('slug', 'items', 'headers', 'canModify');

        return view('itemlist', compact('slug', 'table'));
    }

    public function create()
    {
        $slug = Slug::fromModel(Organization::class);
        $foreigns = ['user'];
        $foreignHandler = new ForeignHandler(
            static fn() => User::query(),
        );

        return view('resources.create', compact('slug', 'foreigns', 'foreignHandler'));
    }

    public function store(OrganizationRequest $request)
    {
        $model = new Organization($request->all());

        if ($model->save()) {
            $this->attachAll($model, $request, 'users');
            return Redirect::route('organizations.index')
                ->with('created', true);
        }

        $error = Lang::get('error.organizations.store');
        return Redirect::back()
            ->withErrors(compact('error'))
            ->withInput($request->input());
    }

    public function show($organization)
    {
        $model = $this->organizations->findOrFail($organization);
        $slug = Slug::fromModel(Organization::class);

        return view('organizations.show', compact('model', 'slug'));
    }

    public function edit($organization)
    {
        $model = $this->organizations->findOrFail($organization);

        return view('organizations.edit', ['organization' => $model]);
    }

    public function update(OrganizationRequest $request, $organization)
    {
        $model = $this->organizations->findOrFail($organization);
        $model->fill($request->all());

        if ($this->user->is_admin) {
            $this->reattachAll($model, $request, 'users');
        }

        if ($model->save()) {
            return Redirect::route('organizations.show', compact('organization'))
                ->with('updated', true);
        }

        $error = Lang::get('error.organizations.update');
        return Redirect::back()
            ->withErrors(compact('error'))
            ->withInput($request->input());
    }

    public function destroy($organization)
    {
        $model = $this->organizations->findOrFail($organization, ['email']);

        if ($model->delete()) {
            return Redirect::route('organizations.index')
                ->with('deleted', $model->email);
        }

        $error = Lang::get('error.organizations.destroy');
        return Redirect::back()->withErrors(compact('error'));
    }
}
