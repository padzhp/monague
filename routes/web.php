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

Route::group(['middleware' => 'App\Http\Middleware\AdminAuthenticate'], function () {

	Route::get('/dashboard/index', 'Dashboard\DashboardController@index');
	
	Route::get('/dashboard/orders', 'Dashboard\OrderController@index');
	Route::get('/dashboard/orders/datatable', 'Dashboard\OrderController@datatable');
	
	Route::get('/dashboard/customers', 'Dashboard\CustomerController@index');
	Route::get('/dashboard/customers/datatable', 'Dashboard\CustomerController@datatable');
	Route::resource('/dashboard/customers','Dashboard\CustomerController');
	
	Route::get('/dashboard/products/datatable', 'Dashboard\ProductController@datatable');
	Route::get('/dashboard/products','Dashboard\ProductController@index');
	Route::get('/dashboard/products/update','Dashboard\ProductController@update');
	Route::get('/dashboard/products/delete','Dashboard\ProductController@delete');
	Route::get('/dashboard/products/create','Dashboard\ProductController@create');
	Route::get('/dashboard/products/details','Dashboard\ProductController@details');
	Route::get('/dashboard/products/description','Dashboard\ProductController@updateDescription');
	Route::post('/dashboard/products','Dashboard\ProductController@store')->name('products.store');

	Route::get('/dashboard/categories', 'Dashboard\CategoryController@index');
	Route::get('/dashboard/categories/datatable', 'Dashboard\CategoryController@datatable');
	Route::get('/dashboard/categories/create','Dashboard\CategoryController@create');
	Route::post('/dashboard/categories','Dashboard\CategoryController@store')->name('categories.store');
	
});

Auth::routes();

Route::get('/dashboard', 'Dashboard\UserController@login');
Route::get('/dashboard/login', 'Dashboard\UserController@login');
Route::get('/home', 'HomeController@index')->name('home');
