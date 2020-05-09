<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Lang;
use Redirect;

class UserController extends Controller
{
    protected $middleware = [
        'auth',
        'can:access_users',
    ];

    public function index()
    {
        $items = User::cursor();

        return view('itemlist', compact('items'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $model = new User($request->all());

        if ($model->save()) {
            return Redirect::route('user.index')->with('created', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.user.store'))
            ->withInput($request->input());
    }

    public function show($user)
    {
        $model = User::findOrFail($user);

        return view('user.show', ['user' => $model]);
    }

    public function edit($user)
    {
        $model = User::findOrFail($user);

        return view('user.edit', ['user' => $model]);
    }

    public function update(UserRequest $request, $user)
    {
        $model = User::findOrFail($user);
        $model->fill($request->all());

        if ($model->save()) {
            return Redirect::route('user.show', compact('user'))
                ->with('updated', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.user.update'))
            ->withInput($request->input());
    }

    public function destroy($user)
    {
        $model = User::findOrFail($user, ['email']);

        if ($model->delete()) {
            return Redirect::route('user.index')
                ->with('deleted', $model->email);
        }

        return Redirect::back()->withErrors(Lang::get('error.user.destroy'));
    }
}
