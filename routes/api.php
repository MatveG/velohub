<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/ajax/cart/new/', 'CartController@new')->name('ajax.cart.new');
Route::patch('/ajax/cart/add/', 'CartController@add')->name('ajax.cart.add');
Route::get('/ajax/widget/{name}/', function (string $name) {
    return app('widget')->show($name, request()->param);
})->name('ajax.widget');
