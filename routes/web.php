<?php

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
//Ruta al home

use App\Events\mediaContentChanged;

Route::get('/', function () {
    return view('client_app');
});

// route to process the form
Auth::routes();

Route::get('/fire', function () {

    event(new mediaContentChanged);

    return "puto el que lee";
});