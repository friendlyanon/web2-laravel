<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
