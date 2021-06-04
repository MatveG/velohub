<?php

Route::namespace('Admin')->group(function () {
    // Categories
    Route::get('/admin/categories', 'CategoryController@index');
    Route::get('/admin/categories/{id}', 'CategoryController@edit');
    Route::post('/admin/categories', 'CategoryController@store');
    Route::patch('/admin/categories/{id}', 'CategoryController@update');
    Route::delete('/admin/categories/{id}', 'CategoryController@destroy');
    Route::post('/admin/categories/{id}/upload-images', 'CategoryController@uploadImages');

    // Products
    Route::get('/admin/products', 'ProductController@index');
    Route::get('/admin/products/{id}', 'ProductController@edit');
    Route::post('/admin/products', 'ProductController@store');
    Route::patch('/admin/products/{id}', 'ProductController@update');
    Route::delete('/admin/products/{id}', 'ProductController@destroy');
    Route::post('/admin/products/{id}/upload-images', 'ProductController@uploadImages');

    // Variants
    Route::get('/admin/variants/{product_id}', 'VariantController@index');
    Route::post('/admin/variants/{product_id}', 'VariantController@store');
    Route::patch('/admin/variants/{id}', 'VariantController@update');
    Route::delete('/admin/variants/{id}', 'VariantController@destroy');
    Route::post('/admin/variants/{id}/upload-images', 'VariantController@uploadImages');
});


