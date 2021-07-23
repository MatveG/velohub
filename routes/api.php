<?php

// Settings
Route::get('/admin/settings', 'SettingController@index');

// Auth
Route::post('/admin/login', 'Api\AuthController@login')->name('login');

Route::namespace('Api')->group(function () {
    // Cart Products
    Route::post('/cart', 'CartController@index');
    Route::patch('/cart/add', 'CartController@add');
    Route::patch('/cart/update', 'CartController@update');
    Route::patch('/cart/remove', 'CartController@remove');

    // Order
    Route::post('/order', 'OrderController');
});

Route::middleware('auth:sanctum')->prefix('admin')->namespace('Admin')->group(function () {
    // Categories
    Route::get('/categories', 'CategoryController@index');
    Route::get('/categories/{id}', 'CategoryController@get');
    Route::post('/categories', 'CategoryController@post');
    Route::patch('/categories/{id}', 'CategoryController@patch');
    Route::delete('/categories/{id}', 'CategoryController@delete');

    // Documents
    Route::get('/documents', 'DocumentController@index');
    Route::get('/documents/{id}', 'DocumentController@get');
    Route::post('/documents', 'DocumentController@post');
    Route::patch('/documents/{id}', 'DocumentController@patch');
    Route::delete('/documents/{id}', 'DocumentController@delete');

    // Features
    Route::get('/features/{categoryId}', 'FeatureController@index');
    Route::post('/features', 'FeatureController@post');
    Route::patch('/features/{id}', 'FeatureController@patch');
    Route::delete('/features/{id}', 'FeatureController@delete');

    // Orders
    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/{id}', 'OrderController@get');
    Route::post('/orders', 'OrderController@post');
    Route::patch('/orders/{id}', 'OrderController@patch');
    Route::delete('/orders/{id}', 'OrderController@delete');

    // Parameters
    Route::get('/parameters/{categoryId}', 'ParameterController@index');
    Route::post('/parameters', 'ParameterController@post');
    Route::patch('/parameters/{id}', 'ParameterController@patch');
    Route::delete('/parameters/{id}', 'ParameterController@delete');

    // Products
    Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@get');
    Route::post('/products', 'ProductController@post');
    Route::patch('/products/{id}', 'ProductController@patch');
    Route::delete('/products/{id}', 'ProductController@delete');

    // Settings
    Route::get('/settings', 'SettingController@index');
    Route::get('/settings/{id}', 'SettingController@get');
    Route::post('/settings', 'SettingController@post');
    Route::patch('/settings/{id}', 'SettingController@patch');
    Route::delete('/settings/{id}', 'SettingController@delete');

    // Users
    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@get');
    Route::post('/users', 'UserController@post');
    Route::patch('/users/{id}', 'UserController@patch');
    Route::delete('/users/{id}', 'UserController@delete');

//    // Variants
//    Route::get('/variants/{product_id}', 'VariantController@index');
//    Route::post('/variants/{product_id}', 'VariantController@store');
//    Route::patch('/variants/{id}', 'VariantController@update');
//    Route::delete('/variants/{id}', 'VariantController@destroy');
//    Route::post('/variants/{id}/upload-images', 'VariantController@uploadImages');

    // Images
    Route::post('/images/upload/{model}/{id}', 'ImageController@upload');
    Route::post('/images/update/{model}/{id}', 'ImageController@update');
});


