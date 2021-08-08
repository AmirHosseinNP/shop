<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
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

//client routes
Route::prefix('')->name('client.')->group(function () {
    //home route
    Route::get('/', [HomeController::class, 'index']);

    //product showing route
    Route::get('/products/{product}', [ClientProductController::class, 'show'])
        ->name('products.show');
});

//admin routes
Route::prefix('/adminpanel')->group(function () {

    Route::get('/', function () {
        return view('admin.home');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    Route::resource('products.pictures', PictureController::class);
    Route::resource('products.discounts', DiscountController::class);
});


