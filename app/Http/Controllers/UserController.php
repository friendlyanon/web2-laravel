<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Organization;
use App\User;
use App\Utils\ForeignHandler;
use App\Utils\Slug;
use Lang;
use Redirect;

class UserController extends Controller
{
    protected $middleware = ['auth', 'can:access_users'];

    public function index()
    {
        $items = User::cursor();
        $headers = User::getHeaders();
        $slug = User::getModelSlug();
        $canModify = true;

        $table = compact('slug', 'items', 'headers', 'canModify');

        return view('itemlist', compact('slug', 'table'));
    }

    public function create()
    {
        $slug = Slug::fromModel(User::class);
        $foreigns = ['organization'];
        $foreignHandler = new ForeignHandler(
            static fn() => Organization::query(),
        );

        return view('resources.create', compact('slug', 'foreigns', 'foreignHandler'));
    }

    public function store(UserRequest $request)
    {
        $model = new User($request->all());
        $this->attachAll($model, $request, 'organizations');

        if ($model->save()) {
            return Redirect::route('users.index');
        }

        return Redirect::back()
            ->withErrors(['error' => Lang::get('error.users.store')])
            ->withInput($request->input());
    }

    public function show(User $user)
    {
        $slug = Slug::fromModel(User::class);

        return view('resources.show', ['model' => $user, 'slug' => $slug]);
    }

    public function edit(User $user)
    {
        $slug = Slug::fromModel(User::class);

        return view('resources.edit', ['model' => $user, 'slug' => $slug]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $this->reattachAll($user, $request, 'organizations');

        if ($user->save()) {
            return Redirect::route('users.show', compact('user'));
        }

        return Redirect::back()
            ->withErrors(['error' => Lang::get('error.users.update')])
            ->withInput($request->input());
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return Redirect::route('users.index');
        }

        return Redirect::back()
            ->withErrors(['error' => Lang::get('error.users.destroy')]);
    }
}
