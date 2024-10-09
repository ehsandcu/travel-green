<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('services', [HomeController::class, 'services'])->name('service.index');
Route::get('about-us', [HomeController::class, 'about'])->name('about.us');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact.us');

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user/info', [UserController::class, 'userInfo'])->name('user.info');
    Route::post('update/user/info', [UserController::class, 'updateUserInfo'])->name('update.user.info');
    Route::group(['middleware' => ['check.user.info']], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
