<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Adminauth\AuthenticatedSessionController;


Route::group(['prefix'=>'admin','as'=>'admin.'],function(){

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->name('session.create');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('logout');

    Route::get('/profile', [AdminController::class, 'create'])
                    ->name('profile');

});