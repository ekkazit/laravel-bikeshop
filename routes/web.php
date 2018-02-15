<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Product Management
Route::group(['prefix' => 'product', 'middleware' => 'auth'], function() {
    Route::get('/', 'ProductController@index');
    Route::get('/search', 'ProductController@search');
    Route::post('/search', 'ProductController@search');
    Route::get('/edit/{id?}', 'ProductController@edit');
    Route::post('/update', 'ProductController@update');
    Route::post('/insert', 'ProductController@insert');
    Route::get('/remove/{id}', 'ProductController@remove');
});

// Home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chart', 'HomeController@view_chart')->middleware('auth');
Route::get('/lang/{locale?}', 'HomeController@index')->name('home');

// Cart
Route::get('/cart/view', 'CartController@viewCart');
Route::get('/cart/add/{id}', 'CartController@addToCart');
Route::get('/cart/delete/{id}', 'CartController@deleteCart');
Route::get('/cart/update/{id}/{qty}', 'CartController@updateCart')->middleware('cart');
Route::get('/cart/checkout', 'CartController@checkout');
Route::get('/cart/viewpo', 'CartController@view_po');
Route::get('/cart/complete', 'CartController@complete');
Route::get('/cart/finish', 'CartController@finish_order');

// Facebook login
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

