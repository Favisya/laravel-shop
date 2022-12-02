<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BasketController;

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

Route::get('/', [MainController::class, 'getMainPage'])->name('index');

Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');

Route::get('/basket', [BasketController::class, 'getBasket'])->name('basket');

Route::get('/basket/place', [BasketController::class, 'getBasketPlace'])->name('basketPlace');

Route::post('/basket/place', [BasketController::class, 'confirmPlace'])->name('confirmPlace');

Route::post('/basket/add/{id}', [BasketController::class, 'addToBasket'])->name('addToBasket');

Route::post('/basket/remove/{id}', [BasketController::class, 'removeFromBasket'])->name('removeFromBasket');

Route::get('/{category}', [CategoryController::class, 'getCategory'])->name('category');

Route::get('/{category}/{product?}', [ProductController::class, 'getProduct'])->name('product');
