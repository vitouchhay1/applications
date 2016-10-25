<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index')->name("admin");
Route::get('/admin', 'AdminContrller@index')->name("admin");
ROUTE::get('/product', 'ProductController@index')->name("product");
ROUTE::get('/addpro', 'ProductController@add')->name("product");

Auth::routes();

Route::get('/home', 'HomeController@index');