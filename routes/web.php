<?php

Route::get('/', static fn() => view('welcome'));

Auth::routes([
    'register' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', static fn() => view('home'))
    ->name('home')
    ->middleware('auth');

Route::resources([
    'users' => 'UserController',
    'organizations' => 'OrganizationController',
    'organizations.discounts' => 'DiscountController',
    'organizations.invoices' => 'InvoiceController',
    'organizations.partners' => 'PartnerController',
    'organizations.partner_groups' => 'PartnerGroupController',
    'organizations.products' => 'ProductController',
    'organizations.taxes' => 'TaxController',
]);
