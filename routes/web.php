<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\FeaturedCategoryController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Admin\ProductPropertyController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\LikeController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;

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

    Route::post('/products/{product}/comments', [CommentController::class, 'store'])
        ->name('products.comments.store');

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

    Route::get('/likes', [LikeController::class, 'index'])
        ->name('likes.index');

    Route::post('/likes/{product}', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/likes/{product}', [LikeController::class, 'destroy'])
        ->name('likes.destroy');
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
        Route::get('/products/{product}/properties', [ProductPropertyController::class, 'index'])
            ->name('products.properties.index');
        Route::get('/products/{product}/properties/create', [ProductPropertyController::class, 'create'])
            ->name('products.properties.create');
        Route::post('/products/{product}/properties', [ProductPropertyController::class, 'store'])
            ->name('products.properties.store');
        Route::get('/products/{product}/comments', [AdminCommentController::class, 'index'])
            ->name('products.comments.index');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])
            ->name('products.comments.destroy');
        Route::resource('propertyGroups', PropertyGroupController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('sliders', SliderController::class);
        Route::get('/featuredCategory/create', [FeaturedCategoryController::class, 'create'])
            ->name('featuredCategory.create');
        Route::post('/featuredCategory', [FeaturedCategoryController::class, 'store'])
            ->name('featuredCategory.store');

    });


