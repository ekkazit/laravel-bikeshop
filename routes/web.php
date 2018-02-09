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
    return view('welcome');
});

// Product Management
Route::get('/product', 'ProductController@index');
Route::get('/product/search', 'ProductController@search');
Route::get('/product/edit/{id?}', 'ProductController@edit');
Route::post('/product/search', 'ProductController@search');
Route::post('/product/update', 'ProductController@update');
Route::post('/product/insert', 'ProductController@insert');
Route::get('/product/remove/{id}', 'ProductController@remove');

// Home
Route::get('/home', 'HomeController@index');

// Cart
Route::get('/cart/view', 'CartController@viewCart');
Route::get('/cart/add/{id}', 'CartController@addToCart');
Route::get('/cart/delete/{id}', 'CartController@deleteCart');
Route::get('/cart/update/{id}/{qty}', 'CartController@updateCart')->middleware('cart');
