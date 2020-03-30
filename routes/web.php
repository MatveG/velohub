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
    Route::get('/admin/products/', 'AdminController@index');
    Route::get('/admin/products/{id}/edit/', 'AdminController@edit');
    Route::post('/admin/products/{id}/update/', 'AdminController@update');
//    Route::get('/admin/products/suggest/', 'AdminController@suggest');
//    Route::get('/admin/products/edit/', 'AdminController@edit');
//    Route::delete('/admin/products/delete/', 'AdminController@delete');

    // Categories
    Route::get('/admin/categories/tree/', 'AdminController@tree');

    // Sku
    Route::post('/admin/sku/store', 'SkuController@store');
    Route::post('/admin/sku/{id}/update', 'SkuController@update');
    Route::post('/admin/sku/{id}/destroy', 'SkuController@destroy');
    Route::post('/admin/sku/{id}/set-default', 'SkuController@setDefault');
    Route::post('/admin/sku/{id}/upload-image', 'SkuController@uploadImage');
    Route::post('/admin/sku/{id}/delete-image/{key}', 'SkuController@deleteImage');
    Route::post('/admin/sku/{id}/update-images', 'SkuController@updateImages');
    Route::get('/admin/sku/{product_id}', 'SkuController@index');

});
