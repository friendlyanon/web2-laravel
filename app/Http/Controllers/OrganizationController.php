<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Organization;
use Lang;
use Redirect;

class OrganizationController extends Controller
{
    protected $middleware = ['auth', 'can:access_organizations'];

    public function index()
    {
        $items = Organization::cursor();

        return view('itemlist', compact('items'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        $model = new Organization($request->all());
        $this->attachAll($model, $request, 'users');

        if ($model->save()) {
            return Redirect::route('organizations.index')
                ->with('created', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.organizations.store'))
            ->withInput($request->input());
    }

    public function show($organization)
    {
        $model = Organization::findOrFail($organization);

        return view('organizations.show', ['organization' => $model]);
    }

    public function edit($organization)
    {
        $model = Organization::findOrFail($organization);

        return view('organizations.edit', ['organization' => $model]);
    }

    public function update(OrganizationRequest $request, $organization)
    {
        $model = Organization::findOrFail($organization);
        $model->fill($request->all());
        $this->reattachAll($model, $request, 'users');

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
        $model = Organization::findOrFail($organization, ['email']);

        if ($model->delete()) {
            return Redirect::route('organizations.index')
                ->with('deleted', $model->email);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.organizations.destroy'));
    }
}
