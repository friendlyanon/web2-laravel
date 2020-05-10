<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get(
    '/user',
    static fn(Request $request) => $request->user(),
);
