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

// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Auth::routes(['verify' => true, 'register' => false]);

Route::middleware(['auth', 'web'])->group(function () {
    /*
    * Dashboard Routes...
    */
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /*
    * User Routes...
    */
    Route::resource('user', 'UserController')->except(['destroy']);
});
