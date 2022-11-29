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

Route::get('/', 'App\Http\Controllers\HomeController@getHome');

Route::get('/bio', 'App\Http\Controllers\BioController@getBio');

Route::get('/bio/info', 'App\Http\Controllers\InfoController@getAll');

Route::get('/bio/info/{info}', 'App\Http\Controllers\InfoController@getRow');
