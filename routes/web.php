<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('services', [HomeController::class, 'services'])->name('service.index');
Route::get('about-us', [HomeController::class, 'about'])->name('about.us');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact.us');
