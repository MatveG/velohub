<?php

// Cart
Route::get('/cart/form/', 'CartController@form')->name('cart.form');
Route::post('/cart/send/', 'CartController@send')->name('cart.send');
// Category
Route::get('/category/{slug}/{id}/{path?}/', 'CategoryController')->where('path', '.*')->name('category.show');
Route::get('/category/{slug}/{id}/{path?}/',
    ['middleware' => ['alter.sort'], 'uses' => 'CategoryController']
)->where('path', '.*')->name('category.show');
// Comment
Route::post('/comment/{product_id}/store/', 'CommentController')->name('comment.store');
// Compare
Route::get('/compare/{slug}/{id}', 'CompareController')->name('category.compare');
// Mailing
Route::post('/mailing/subscribe/', 'MailingController@subscribe')->name('mailing.subscribe');
Route::post('/mailing/unsubscribe/', 'MailingController@unsubscribe')->name('mailing.un subscribe');
// Product
Route::get('/product/{slug}/{id}/', 'ProductController')->name('product.show');
// Search
Route::get('/search/{path?}/', 'SearchController')->where('path', '.*')->name('product.search');
// Document
Route::get('/{slug}/', 'DocumentController@show')->name('content.show');
// Root
Route::get('/', 'RootController@index')->name('index');





// Ajax
Route::post('/ajax/cart/new/', 'CartController@new')->name('ajax.cart.new');
Route::patch('/ajax/cart/add/', 'CartController@add')->name('ajax.cart.add');
Route::get('/ajax/widget/{name}/', function (string $name) {
    return app('widget')->show($name, request()->param);
})->name('ajax.widget');

// Images routing
Route::get('/media/ct/{img}')->name('img.category');
Route::get('/media/pt/{img}')->name('img.product');
Route::get('/media/ul/{img}')->name('img.upload');

// Admin
Route::view('/admin/', 'Admin::index');

Route::namespace('Admin')->group(function () {
    // categories
    Route::get('/admin/categories', 'CategoryController@index');
    Route::get('/admin/categories/{id}', 'CategoryController@edit');
    Route::post('/admin/categories', 'CategoryController@store');
    Route::patch('/admin/categories/{id}', 'CategoryController@update');
    Route::delete('/admin/categories/{id}', 'CategoryController@destroy');
    Route::post('/admin/categories/{id}/upload-images', 'CategoryController@uploadImages');

    // products
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
