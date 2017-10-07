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

});

Route::get('/dashboard/', 'Dashboard\DashboardController@login');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
