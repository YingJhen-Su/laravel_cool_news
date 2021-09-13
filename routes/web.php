<?php

use Illuminate\Support\Facades\Route;

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
  
Route::get('/', 'NewsController@index');
Route::get('/news', 'NewsController@index');
Route::get('/news/{id}', 'NewsController@show');
Route::get('/categories/{id}', 'CategoryController@show');
Route::get('/tags/{id}', 'TagController@show');

Route::prefix('admin')->group(function () {
  Route::get('/','Auth\LoginController@showLoginForm');
  Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
  Route::post('/login','Auth\LoginController@login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
  Route::post('/logout','Auth\LoginController@logout');
  Route::resource('news', 'Admin\NewsController');
  Route::get('/categories/{id}', 'Admin\CategoryController@show');
  Route::get('/tags/{id}', 'Admin\TagController@show');
});