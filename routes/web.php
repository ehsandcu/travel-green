<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmissionController;
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
Route::post('/login', [AuthController::class, 'login'])->name('check.login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('services', [HomeController::class, 'services'])->name('service.index');
Route::get('about-us', [HomeController::class, 'about'])->name('about.us');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact.us');
Route::post('contact-us/info/store', [HomeController::class, 'storeContactUsInfo'])->name('contact.us.store');

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user/info', [UserController::class, 'userInfo'])->name('user.info');
    Route::post('update/user/info', [UserController::class, 'updateUserInfo'])->name('update.user.info');
    Route::group(['middleware' => ['check.user.info']], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/show', [DashboardController::class, 'index'])->name('dashboard');
            
            Route::group(['prefix' => 'contact-us'], function () {
                Route::get('/', [ContactUsController::class, 'index'])->name('dashboard.contact.us');
                Route::get('/show/{id}', [ContactUsController::class, 'showContact'])->name("contact_us.show");
                Route::post('/load/contact/list', [ContactUsController::class, 'loadContactUsList'])->name("load.contact_us.list");
            });

            Route::group(['prefix' => 'emission'], function () {
                Route::get('/list', [EmissionController::class, 'index'])->name("emission.index");
                Route::post('/graphData', [DashboardController::class, 'getGraphData'])->name("emission.graph.data");
                Route::post('/store', [EmissionController::class, 'storeEmission'])->name("emission.store");
                Route::post('/delete/{id}', [EmissionController::class, 'deleteEmission'])->name("emission.delete");
                Route::post('/load/emission', [EmissionController::class, 'loadEmission'])->name("load.emissions");
            });
        });
    });
});
