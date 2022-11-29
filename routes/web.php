<?php

use Illuminate\Support\Facades\File;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bio', function () {
    return view('bio');
});

Route::get('/bio/info', function () {
    return view('allinfo', ['blocks' => \App\Models\InfoPost::all()]);
});

Route::get('/bio/info/{info}', function ($slug) {
    //Find an info by its slug and passed to the view called "info"
    return view('info', ['info' => \App\Models\Info::find($slug)]);
});
