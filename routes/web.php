<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthController as HAuthController;

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

Route::any('/', [HomeController::class, 'index'])->name(
    'home'
);


Route::any('/search', [HomeController::class, 'search'])->name(
    'search'
);

Route::any('/about', [HomeController::class, 'about'])->name(
    'about'
);

Route::any('/profile', [HomeController::class, 'profile'])->name(
    'profile'
);

Route::any('/order/{uuid}', [HomeController::class, 'order_view'])->name(
    'order.view'
);

Route::any('/contact-us', [HomeController::class, 'contact'])->name(
    'contact'
);

Route::any('/property/{uuid}', [HomeController::class, 'view_property'])->name(
    'property.view'
);

Route::any('/post/search', [HomeController::class, 'post_search'])->name(
    'post.search'
);

Route::post('/post/login', [HAuthController::class, 'login'])->name(
    'post.login'
);


Route::get('/post/logout', [HAuthController::class, 'post_logout'])->name(
    'post.logout'
);

Route::post('/post/register', [HAuthController::class, 'register'])->name(
    'post.register'
);

Route::any('super/login', [AuthController::class, 'adminLogin'])->name(
    'admin.login'
);

Route::any('boss/ttt', [AuthController::class, 'testing'])->name(
    'admin.ttt'
);

// Route::group(['middleware' => 'auth:admin', 'prefix' => 'manager'], function () {

Route::prefix('boss')
    ->name('admin.')
    ->namespace('App\Http\Controllers\Web\Admin')
    ->group(function () {
        Route::middleware('manager')->group(__DIR__ . '/manager.php');
    });
