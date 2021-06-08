<?php

// admin only!
Route::namespace('Admin')->group(function () {
    // Settings
    Route::get('/settings', 'SettingController@index');

    // Categories
    Route::get('/categories', 'CategoryController@index');
//    Route::get('/categories/{id}', 'CategoryController@edit');
//    Route::post('/categories', 'CategoryController@store');
//    Route::patch('/categories/{id}', 'CategoryController@update');
//    Route::delete('/categories/{id}', 'CategoryController@destroy');
//    Route::post('/categories/{id}/upload-images', 'CategoryController@uploadImages');

    // Products
    Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@get');
    Route::post('/products', 'ProductController@post');
    Route::patch('/products/{id}', 'ProductController@patch');
    Route::delete('/products/{id}', 'ProductController@delete');
    Route::post('/products/{id}/upload-images', 'ProductController@uploadImages');

//    // Variants
//    Route::get('/variants/{product_id}', 'VariantController@index');
//    Route::post('/variants/{product_id}', 'VariantController@store');
//    Route::patch('/variants/{id}', 'VariantController@update');
//    Route::delete('/variants/{id}', 'VariantController@destroy');
//    Route::post('/variants/{id}/upload-images', 'VariantController@uploadImages');
});


