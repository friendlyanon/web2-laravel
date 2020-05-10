<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Organization;
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

        return view('itemlist', compact('items'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        $model = new Organization($request->all());

        if ($model->save()) {
            $this->attachAll($model, $request, 'users');
            return Redirect::route('organizations.index')
                ->with('created', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.organizations.store'))
            ->withInput($request->input());
    }

    public function show($organization)
    {
        $model = $this->organizations->findOrFail($organization);

        return view('organizations.show', ['organization' => $model]);
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

        return Redirect::back()
            ->withErrors(Lang::get('error.organizations.update'))
            ->withInput($request->input());
    }

    public function destroy($organization)
    {
        $model = $this->organizations->findOrFail($organization, ['email']);

        if ($model->delete()) {
            return Redirect::route('organizations.index')
                ->with('deleted', $model->email);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.organizations.destroy'));
    }
}
