<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Middleware\CheckPermission;
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
    Route::get('/', [HomeController::class, 'index'])->name('index');

    //product showing route
    Route::get('/products/{product}', [ClientProductController::class, 'show'])
        ->name('products.show');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register/sendmail', [RegisterController::class, 'sendMail'])
        ->name('register.sendmail');

    Route::get('/register/check-otp/{user}', [RegisterController::class, 'checkOtp'])
        ->name('register.checkOtp');

    Route::post('/register/verify-otp/{user}', [RegisterController::class, 'verifyOtp'])
        ->name('register.verifyOtp');

    Route::delete('/logout', [RegisterController::class, 'logout'])
        ->name('logout');

});

//admin routes
Route::prefix('/adminpanel')
    ->middleware(['auth', 'checkPermission:view-dashboard'])
    ->group(function () {

    Route::get('/', function () {
        return view('admin.home');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    Route::resource('products.pictures', PictureController::class);
    Route::resource('products.discounts', DiscountController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


