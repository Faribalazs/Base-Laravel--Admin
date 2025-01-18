<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Workerauth\GoogleSocialiteController;
use App\Http\Controllers\Workerauth\NewPasswordController;
use App\Http\Controllers\Workerauth\WorkerVerifyEmailController;
use App\Http\Controllers\Workerauth\RegisteredUserController;
use App\Http\Controllers\Workerauth\PasswordResetLinkController;
use App\Http\Controllers\Workerauth\ConfirmablePasswordController;
use App\Http\Controllers\Workerauth\AuthenticatedSessionController;
use App\Http\Controllers\Workerauth\WorkerEmailVerificationPromptController;
use App\Http\Controllers\Workerauth\WorkerEmailVerificationNotificationController;



Route::group(['prefix'=>'contractor','as'=>'worker.'],function(){
    Route::middleware(['guest'])->group(function () {
        //Google
        Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle'])->name('login.google');
        Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback'])->name('callback.google');

        Route::get('/register', [RegisteredUserController::class, 'create'])
                        ->name('register');

        Route::post('/register', [RegisteredUserController::class, 'store']);

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                        ->name('session.create');

        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                        ->name('password.request');

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                        ->name('password.email');
                            
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                        ->name('password.reset');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
                        ->name('password.update');

                        
        Route::get('/verify-email', [WorkerEmailVerificationPromptController::class, '__invoke'])
                            ->name('verification.notice');

        Route::get('/verify-email/{id}/{hash}', [WorkerVerifyEmailController::class, '__invoke'])
                        ->middleware(['signed', 'throttle:6,1'])
                        ->name('verification.verify');

        Route::post('/email/verification-notification', [WorkerEmailVerificationNotificationController::class, 'store'])
                        ->middleware(['throttle:6,1'])
                        ->name('verification.send');
    });

    Route::group(['middleware' => ['auth:worker']],function(){

        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                        ->name('password.confirm');

        Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                        ->name('logout');
    });
});

