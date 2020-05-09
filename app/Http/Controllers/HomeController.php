<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    protected $middleware = ['auth'];

    public function index(): Renderable
    {
        return view('home');
    }
}
