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
Route::get('/admin/', function () {
    return view('admin');
});

Route::namespace('Admin')->group(function () {
    Route::get('/admin/product/{id}/edit/', 'ProductContoller@edit');
    Route::post('/admin/product/{id}/update/', 'ProductContoller@update');
//    Route::get('/admin/products/suggest/', 'AdminController@suggest');
//    Route::get('/admin/products/edit/', 'AdminController@edit');
//    Route::delete('/admin/products/delete/', 'AdminController@delete');
    Route::post('/admin/product/{id}/images-upload', 'ProductContoller@imagesUpload');
    Route::post('/admin/product/{id}/images-update', 'ProductContoller@imagesUpdate');
    Route::get('/admin/product/', 'ProductContoller@index');

    // Categories
    //Route::post('/admin/category/store', 'AdminController@storeOrUpdate');
    Route::post('/admin/category/{id}/update', 'AdminController@storeOrUpdate');

    Route::post('/admin/category/list/', 'AdminController@list');
    Route::get('/admin/category/{id}/edit/', 'AdminController@edit');
    Route::get('/admin/category/', 'AdminController@index');

    // Variant
    Route::post('/admin/variant/store', 'VariantController@store');
    Route::post('/admin/variant/{id}/update', 'VariantController@update');
    Route::post('/admin/variant/{id}/destroy', 'VariantController@destroy');
    Route::post('/admin/variant/{id}/images-upload', 'VariantController@imagesUpload');
    Route::post('/admin/variant/{id}/images-update', 'VariantController@imagesUpdate');
    Route::get('/admin/variant/{product_id}', 'VariantController@index');

});
