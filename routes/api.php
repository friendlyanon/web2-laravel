<?php

Route::get('filter/users', 'ApiController@filterUsers')
    ->name('api:filter_users');

Route::get('filter/organizations', 'ApiController@filterOrganizations')
    ->name('api:filter_organizations');

Route::get(
    'filter/organizations/{organization}/{resource}',
    'ApiController@filterResource'
)->name('api:filter_resource');
