<?php

// Category
Route::get('/shop/{latin}/{id}/compare/', 'CategoryController@compare')->name('category.compare');
Route::get('/shop/{latin}/{id}/{path?}/', 'CategoryController@show')->where('path', '.*')->name('category.show');
// Product
Route::get('/product/search/{path?}/', 'ProductController@search')->where('path', '.*')->name('product.search');
Route::get('/product/{latin}/{id}/', 'ProductController@show')->name('product.show');
// Comment
Route::post('/comment/{product_id}/store/', 'CommentController@store')->name('comment.store');
// Cart
Route::get('/cart/form/', 'CartController@form')->name('cart.form');
Route::post('/cart/send/', 'CartController@send')->name('cart.send');
// Content
Route::get('/content/{latin}/', 'ContentController@show')->name('content.show');
// Mailing
Route::post('/mailing/store/', 'MailingController@store')->name('mailing.store');
Route::post('/mailing/destroy/', 'MailingController@destroy')->name('mailing.destroy');
// Index
Route::get('/', 'IndexController@index')->name('index');

// Ajax
Route::post('/ajax/cart/new/', 'CartController@new')->name('ajax.cart.new');
Route::patch('/ajax/cart/add/', 'CartController@add')->name('ajax.cart.add');
Route::get('/ajax/widget/{name}/', function (string $name) {
    return app('widget')->show($name, request()->param);
})->name('ajax.widget');

// Images routing // !remove!
Route::get('/media/pt/{img}')->name('img.category');
Route::get('/media/pt/{img}')->name('img.product');
Route::get('/media/ul/{img}')->name('img.upload');

// Admin
Route::view('/admin/', 'admin');

Route::namespace('Admin')->group(function () {
    // Products
    Route::get('/admin/products/{id}/edit/', 'ProductContoller@edit');
    Route::post('/admin/products/{id}/save/', 'ProductContoller@save');
    Route::post('/admin/products/{id}/destroy', 'ProductContoller@destroy');
    Route::post('/admin/products/{id}/images-upload', 'ProductContoller@imagesUpload');
    Route::post('/admin/products/{id}/images-update', 'ProductContoller@imagesUpdate');
    Route::get('/admin/products/', 'ProductContoller@index');

    // Categories
    Route::get('/admin/categories/{id}/edit', 'CategoryController@edit');
    Route::post('/admin/categories/{id}/save', 'CategoryController@save ');
    Route::post('/admin/categories/{id}/destroy', 'CategoryController@destroy');
    Route::post('/admin/categories/{id}/images-upload', 'CategoryController@imagesUpload');
    Route::post('/admin/categories/{id}/images-update', 'CategoryController@imagesUpdate');
    Route::post('/admin/categories/list', 'CategoryController@list');
    Route::get('/admin/categories', 'CategoryController@index');

    // Variants
    Route::post('/admin/variant/store', 'VariantController@store');
    Route::post('/admin/variant/{id}/update', 'VariantController@update');
    Route::post('/admin/variant/{id}/destroy', 'VariantController@destroy');
    Route::post('/admin/variant/{id}/images-upload', 'VariantController@imagesUpload');
    Route::post('/admin/variant/{id}/images-update', 'VariantController@imagesUpdate');
    Route::get('/admin/variant/{product_id}', 'VariantController@index');

});
