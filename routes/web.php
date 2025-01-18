<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

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
Route::middleware(['guest'])->group(function () {
    //Google
    Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback'])->name('callback.google');
});

Route::get('/', [DashboardController::class, 'home'])->name('home');

Route::get('/about-us', [DashboardController::class, 'aboutUs'])->name('about.us');

//auth route for both 
Route::group(['middleware' => ['auth']], function() { 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// for users
Route::group(['middleware' => ['auth', 'role:user']], function() { 
    Route::get('/profile', [DashboardController::class, 'profile'])->name('myprofile');
});

require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';
require __DIR__.'/workerauth.php';
require __DIR__.'/worker.php';
require __DIR__.'/admin.php';
