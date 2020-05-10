<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Lang;
use Redirect;

class UserController extends Controller
{
    protected $middleware = ['auth', 'can:access_users'];

    public function index()
    {
        $items = User::cursor();

        return view('itemlist', compact('items'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $model = new User($request->all());
        $this->attachAll($model, $request, 'organizations');

        if ($model->save()) {
            return Redirect::route('users.index')->with('created', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.users.store'))
            ->withInput($request->input());
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $this->reattachAll($user, $request, 'organizations');

        if ($user->save()) {
            return Redirect::route('users.show', compact('user'))
                ->with('updated', true);
        }

        return Redirect::back()
            ->withErrors(Lang::get('error.users.update'))
            ->withInput($request->input());
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return Redirect::route('users.index')
                ->with('deleted', $user->email);
        }

        return Redirect::back()->withErrors(Lang::get('error.users.destroy'));
    }
}
