<?php

// Cart products
Route::get('/api/carts/products', 'CartProductController@index');
Route::patch('/api/carts/products/attach', 'CartProductController@attach');
Route::patch('/api/carts/products/detach', 'CartProductController@detach');
Route::patch('/api/carts/products/update', 'CartProductController@update');

// Order
Route::post('/api/orders', 'OrderController');

// Admin
Route::view('/admin/', 'Admin::index');

//// Cart
//Route::get('/cart/form/', 'CartController')->name('cart');

// Category
Route::get('/category/{slug}/{id}/{path?}/', 'CategoryController')
    ->where('path', '.*')
    ->middleware(['parse.path', 'parse.sort'])
    ->name('category');

// Comment
Route::post('/comment/{product_id}/store', 'CommentController@store');

// Compare
Route::get('/compare/{slug}/{id}', 'CompareController')->name('compare');

// Checkout
Route::get('/checkout', 'CheckoutController')->name('checkout');

// Product
Route::get('/product/{slug}/{id}', 'ProductController')->name('product');

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
//Route::get('/images/ct/{img}', 'RootController')->name('img.category');
//Route::get('/images/pt/{img}', 'RootController')->name('img.product');
//Route::get('/images/ul/{img}', 'RootController')->name('img.upload');
