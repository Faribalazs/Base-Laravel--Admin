<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/users', [AdminController::class, 'selectUsers'])
        ->name('users');

    Route::put('/users/ban', [AdminController::class, 'banUser'])
        ->name('ban.user');

    Route::put('/users/unban', [AdminController::class, 'unbanUser'])
        ->name('unban.user');

    Route::get('/workers', [AdminController::class, 'selectWorkers'])
        ->name('workers');

    Route::put('/workers/ban', [AdminController::class, 'banWorker'])
        ->name('ban.worker');

    Route::put('/workers/unban', [AdminController::class, 'unbanWorker'])
        ->name('unban.worker');

    Route::post('/workers/promote', [AdminController::class, 'promoteWorkerToPremium'])
        ->name('promote.worker');
        
    Route::get('/premium-workers', [AdminController::class, 'selectPremiumWorkers'])
        ->name('workers.with.premium');

    Route::post('/premium-workers/demote', [AdminController::class, 'demoteWorker'])
        ->name('demote.worker');

    Route::get('/categories', [AdminController::class, 'selectCategories'])
        ->name('categories');

    Route::post('/categories/insert', [AdminController::class, 'insertCategory'])
        ->name('insert.category');

    Route::put('/categories/edit', [AdminController::class, 'editCategory'])
        ->name('edit.category');

    Route::delete('/categories/delete', [AdminController::class, 'deleteCategory'])
        ->name('delete.category');

    Route::get('/subcategories', [AdminController::class, 'selectSubcategories'])
        ->name('subcategories');

    Route::post('/subcategories/insert', [AdminController::class, 'insertSubcategory'])
        ->name('insert.subcategory');

    Route::put('/subcategories/edit', [AdminController::class, 'editSubcategory'])
        ->name('edit.subcategory');

    Route::delete('/subcategories/delete', [AdminController::class, 'deleteSubcategory'])
        ->name('delete.subcategory');
    
    Route::get('/pozicija', [AdminController::class, 'selectPozicija'])
        ->name('pozicija');

    Route::post('/pozicija/insert', [AdminController::class, 'insertPozicija'])
        ->name('insert.pozicija');

    Route::put('/pozicija/edit', [AdminController::class, 'editPozicija'])
        ->name('edit.pozicija');

    Route::delete('/pozicija/delete', [AdminController::class, 'deletePozicija'])
        ->name('delete.pozicija');

    Route::get('/sections', [AdminController::class, 'sectionsCreate'])
        ->name('sections.create');

    Route::get('/sections/edit/{id}', [AdminController::class, 'sectionsEdit'])
        ->name('sections.edit');

    Route::post('/sections/edit/{id}', [AdminController::class, 'sectionsEditDone'])
        ->name('sections.edit.done');

    Route::delete('/sections/delete', [AdminController::class, 'sectionsDelete'])
        ->name('sections.delete');

});