<?php

// Cart products
Route::get('/api/carts/products', 'CartProductController@index');
Route::patch('/api/carts/products/attach', 'CartProductController@attach');
Route::patch('/api/carts/products/detach', 'CartProductController@detach');
Route::patch('/api/carts/products/update', 'CartProductController@update');

// Admin
Route::view('/admin/', 'Admin::index');

// Cart
Route::get('/cart/form/', 'CartController@form')->name('cart.form');

// Category
Route::get('/category/{slug}/{id}/{path?}/', 'CategoryController')
    ->where('path', '.*')
    ->middleware(['parse.path', 'parse.sort'])
    ->name('category');

// Comment
Route::post('/comment/{product_id}/store/', 'CommentController@store')->name('comment.store');

// Compare
Route::get('/compare/{slug}/{id}', 'CompareController')->name('category.compare');

// Order
Route::post('/order/', 'OrderController@store')->name('order.store');

// Product
Route::get('/product/{slug}/{id}/', 'ProductController')->name('product.show');

// Search
Route::get('/search/{path?}/', 'SearchController')
    ->where('path', '.*')
    ->middleware(['parse.path', 'parse.sort'])
    ->name('search');

// Document
Route::get('/{slug}/', 'DocumentController')->name('document');

// Root
Route::get('/', 'RootController')->name('index');

// Images routing
Route::get('/media/ct/{img}')->name('img.category');
Route::get('/media/pt/{img}')->name('img.product');
Route::get('/media/ul/{img}')->name('img.upload');

Route::namespace('Admin')->group(function () {
    // Categories
    Route::get('/admin/categories', 'CategoryController@index');
    Route::get('/admin/categories/{id}', 'CategoryController@edit');
    Route::post('/admin/categories', 'CategoryController@store');
    Route::patch('/admin/categories/{id}', 'CategoryController@update');
    Route::delete('/admin/categories/{id}', 'CategoryController@destroy');
    Route::post('/admin/categories/{id}/upload-images', 'CategoryController@uploadImages');

    // Products
    Route::get('/admin/products/', 'ProductController@index');
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
