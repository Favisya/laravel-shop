<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Person\OrderController as PersonOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CategoryController as UserCategoryController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes([
    'reset'   => false,
    'verify'  => false,
    'confirm' => false
]);

Route::get('reset', [ResetController::class, 'resetProject'])->name('reset');

Route::middleware(['auth'])->group(function () {
    Route::group([
        'prefix' => 'person',
    ], function () {
        Route::get('/orders', [PersonOrderController::class, 'index'])->name('person.orders');
        Route::get('/orders/{order}', [PersonOrderController::class, 'show'])->name('person.order');
    });

    Route::group([
        'middleware' => 'auth',
        'prefix'     => 'admin',
    ], function () {
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('home');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->  name('order.show');
            Route::resource('categories', AdminCategoryController::class);
            Route::resource('products', AdminProductController::class);
        });
    });
});

Route::post('/subscription/{product}', [ProductController::class, 'subscribeToProduct'])->name('subscription');

Route::group(['prefix' => 'basket'], function () {
    Route::post('/add/{product}', [BasketController::class, 'addToBasket'])->name('addToBasket');

    Route::group(['middleware' => 'is_basket_empty',], function () {
        Route::get('/', [BasketController::class, 'getBasket'])->name('basket');
        Route::get('/place', [BasketController::class, 'getBasketPlace'])->name('basketPlace');
        Route::post('/place', [BasketController::class, 'confirmPlace'])->name('confirmPlace');
        Route::post('/remove/{product}', [BasketController::class, 'removeFromBasket'])->name('removeFromBasket');
    });
});

Route::get('/logout', [LoginController::class, 'logout'])->name('doLogout');

Route::get('/', [MainController::class, 'getMainPage'])->name('index');

Route::get('/categories', [UserCategoryController::class, 'getCategories'])->name('categories');

Route::get('/{category}', [UserCategoryController::class, 'getCategory'])->name('category');

Route::get('/{category}/{product}', [ProductController::class, 'getProduct'])->name('product');
