<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerControllers\WorkerController;
use App\Http\Controllers\WorkerControllers\NewPonuda;
use App\Http\Controllers\WorkerControllers\NewOptions;
use App\Http\Controllers\WorkerControllers\OptionsController;
use App\Http\Controllers\WorkerControllers\Archive;

/*
|--------------------------------------------------------------------------
| Worker Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth:worker', 'role:worker|super_worker']], function() { 

    Route::get('storage/{filename}', function ($filename)
    {
        return Image::make(storage_path('app/logo/' . $filename))->response();
    })->name('show.img');


    Route::get('contractor/catalogue', [WorkerController::class, 'catalogueCategories'])
        ->name('worker.catalogue-categories');

    //profile routes
    Route::get('contractor/profile', [WorkerController::class, 'profile'])
        ->name('worker.myprofile');

    Route::put('contractor/profile/setup', [WorkerController::class, 'setupProfile'])
        ->name('worker.myprofile.send.email');

    Route::get('contractor/profile/company', [WorkerController::class, 'personalData'])
        ->name('worker.personal.data');

    Route::post('contractor/profile/company/save', [WorkerController::class, 'savePersonalData'])
        ->name('worker.personal.data.save');

    Route::get('contractor/profile/contacts', [WorkerController::class, 'myContacts'])
        ->name('worker.personal.contacts');

    Route::get('contractor/profile/contacts/edit/individual/{id}', [WorkerController::class, 'editContactFizicka'])
        ->name('worker.personal.contacts.edit.fizicka');

    Route::post('contractor/profile/contacts/individual/delete', [WorkerController::class, 'deleteContactFizicka'])
        ->name('worker.personal.contacts.delete.fizicka');

    Route::get('contractor/profile/contacts/edit/legal-entity/{id}', [WorkerController::class, 'editContactPravno'])
        ->name('worker.personal.contacts.edit.pravna');

    Route::post('contractor/profile/contacts/legal-entity/delete', [WorkerController::class, 'deleteContactPravno'])
        ->name('worker.personal.contacts.delete.pravna');

    Route::get('contractor/profile/add/individual', [WorkerController::class, 'addFizickoIndex'])
        ->name('worker.personal.contacts.add.individual');

    Route::post('contractor/profile/add/individual/save', [WorkerController::class, 'saveFizickoLice'])
        ->name('worker.personal.contacts.add.individual.save');

    Route::get('contractor/profile/add/legal-entity', [WorkerController::class, 'addPravnoIndex'])
        ->name('worker.personal.contacts.add.legal-entity');

    Route::post('contractor/profile/add/legal-entity/save', [WorkerController::class, 'savePravnoLice'])
        ->name('worker.personal.contacts.add.legal-entity.save');

    Route::delete('contractor/profile/company/delete', [WorkerController::class, 'companyDelete'])
        ->name('worker.personal.company.delete');

    Route::get('contractor/profile/settings', [WorkerController::class, 'profileSettingsCreate'])
        ->name('worker.personal.account.settings');

    Route::get('contractor/profile/contact/{lice}/{id}', [WorkerController::class, 'showContact'])
        ->name('worker.personal.contacts.show');
        
    Route::post('contractor/profile/settings/change-password', [WorkerController::class, 'updatePassword'])
        ->name('worker.personal.account.settings.update-password');

    Route::put('contractor/profile/settings/change-data', [WorkerController::class, 'editUser'])
        ->name('worker.personal.account.settings.change-data');

    Route::get('storage/avatars/{filename}', function ($filename){
            return Image::make(storage_path('app/public/workers/avatars/' . $filename))->response();})
        ->name('show.avatar');

    // nova ponuda
    Route::get('contractor/new', [NewPonuda::class, 'create'])
        ->name('worker.new.ponuda');

    Route::middleware(['freeTrialOffers'])->group(function () {
        Route::post('contractor/new/store', [NewPonuda::class, 'storePonuda'])
            ->name('worker.store.new.ponuda');

        Route::post('contractor/new/store/done', [NewPonuda::class, 'ponudaDone'])
            ->name('worker.store.new.ponuda.done');
            
        Route::put('contractor/new/store/updatedesc/', [NewPonuda::class, 'updateDescription'])
            ->name('worker.store.new.update.desc');
    });

    Route::delete('contractor/new/store/delete', [NewPonuda::class, 'deletePonuda'])
        ->name('worker.store.new.ponuda.delete');

    // nova ponuda axios endpoint routes start
    
    Route::get('contractor/get-categories/{id}/{worker_id}', [NewPonuda::class, 'getCategoriesFromId'])
        ->name('worker.new.get.categories');

    Route::get('contractor/get-subcategories/{id}/{worker_id}', [NewPonuda::class, 'getSubcategoriesFromId'])
        ->name('worker.new.get.subcategories');

    Route::get('contractor/get-pozicija/{id}/{worker_id}', [NewPonuda::class, 'getPozicijaFromId'])
        ->name('worker.new.get.pozicija');

    // nova ponuda axios endpoint routes end

    //nove kategorije
    Route::get('contractor/new/options', [NewOptions::class, 'create'])
        ->name('worker.options.new');
    
    Route::get('contractor/new/worktype', [NewOptions::class, 'WorkTypeCreate'])
        ->name('worker.options.create.new.work-type');

    Route::get('contractor/new/category', [NewOptions::class, 'CategoryCreate'])
        ->name('worker.options.create.new.category');

    Route::get('contractor/new/subcategory', [NewOptions::class, 'SubCategoryCreate'])
        ->name('worker.options.create.new.subcategory');

    Route::get('contractor/new/pozicija', [NewOptions::class, 'pozicijaCreate'])
        ->name('worker.options.create.new.pozicija');

    Route::middleware(['freeTrialMyCategories'])->group(function () {
        Route::post('contractor/new/worktype/store', [NewOptions::class, 'store_worktype'])
            ->name('worker.options.store.new.work-type');

        Route::post('contractor/new/category/store', [NewOptions::class, 'store_category'])
            ->name('worker.options.store.new.category');

        Route::post('contractor/new/subcategory/store', [NewOptions::class, 'store_subcategory'])
            ->name('worker.options.store.new.subcategory');

        Route::post('contractor/new/pozicija/store', [NewOptions::class, 'store_pozicija'])
            ->name('worker.options.store.new.pozicija');
    });

    //moje kategorije
    Route::get('contractor/my-categories/', [OptionsController::class, 'create'])
        ->name('worker.options.update');

    Route::get('contractor/my-categories/show/work-type/{work_type}', [OptionsController::class, 'showWorkType'])
        ->name('worker.options.show.worktype');

    Route::get('contractor/my-categories/show/category/{category}', [OptionsController::class, 'showCategory'])
        ->name('worker.options.show.category');

    Route::get('contractor/my-categories/show/subcategory/{subcategory}', [OptionsController::class, 'showSubcategory'])
        ->name('worker.options.show.subcategory');

    Route::get('contractor/my-categories/show/pozicija/{pozicija}', [OptionsController::class, 'showPozicija'])
        ->name('worker.options.show.pozicija');

    Route::middleware(['freeTrialMyCategories'])->group(function () {
        Route::put('contractor/my-categories/show/work-type/update', [OptionsController::class, 'updateWorkType'])
            ->name('worker.options.update.worktype');

        Route::put('contractor/my-categories/show/category/update', [OptionsController::class, 'updateCategory'])
            ->name('worker.options.update.category');

        Route::put('contractor/my-categories/show/subcategory/update', [OptionsController::class, 'updateSubcategory'])
            ->name('worker.options.update.subcategory');

        Route::put('contractor/my-categories/show/pozicija/update', [OptionsController::class, 'updatePozicija'])
            ->name('worker.options.update.pozicija');
    });
        
    Route::put('contractor/my-categories/delete/work-type', [OptionsController::class, 'deleteWorkType'])
        ->name('worker.options.delete.worktype');

    Route::put('contractor/my-categories/delete/category', [OptionsController::class, 'deleteCategory'])
        ->name('worker.options.delete.category');

    Route::put('contractor/my-categories/delete/subcategory', [OptionsController::class, 'deleteSubcategory'])
        ->name('worker.options.delete.subcategory');

    Route::put('contractor/my-categories/delete/pozicija', [OptionsController::class, 'deletePozicija'])
        ->name('worker.options.delete.pozicija');

    Route::post('contractor/mail/pdf', [Archive::class, 'sendPDF'])
        ->name('worker.archive.send.mail');

    Route::post('contractor/mail/contract', [Archive::class, 'sendPDFContract'])
        ->name('worker.archive.send.contract');
        
    //archive
    
    Route::get('contractor/archive', [Archive::class, 'create'])
            ->name('worker.archive');

    Route::get('contractor/archive/search/filter', [Archive::class, 'search'])
    ->name('worker.archive.search');

    Route::get('contractor/archive/search/napomena', [Archive::class, 'searchNapomena'])
        ->name('worker.archive.search.napomena');

    Route::middleware(['checkSwapRecord'])->group(function () {
        Route::get('contractor/archive/success', [Archive::class, 'generatePdfSuccess'])
            ->name('worker.archive.success');

        Route::post('contractor/archive/submit/contact/individual', [Archive::class, 'submitContact'])
            ->name('worker.archive.submit.contact');

        Route::get('contractor/archive/select-template', [Archive::class, 'selectTempleteCreate'])
            ->name('worker.archive.select.template');

        Route::post('contractor/archive/submit/contact/legal-entity', [Archive::class, 'submitContactPravna'])
            ->name('worker.archive.submit.contact.pravna');

        Route::delete('contractor/archive/delete', [Archive::class, 'delete'])
            ->name('worker.archive.delete');

        Route::delete('contractor/archive/element/delete', [Archive::class, 'deleteElement'])
            ->name('worker.archive.delete.element');

        Route::middleware(['freeTrialOffers'])->group(function () {
            Route::get('contractor/archive/edit/{ponuda_id}', [Archive::class, 'editPonuda'])
                ->name('worker.archive.edit');
        });

        Route::get('contractor/archive/select/template', [Archive::class, 'selectTamplate'])
            ->name('worker.archive.template.select');
        
        Route::post('contractor/archive/generate/pdf', [Archive::class, 'redirctToGeneratePdf'])
            ->name('worker.archive.genarte.tamplate.pdf');

        Route::get('contractor/archive/generate/pdf', [Archive::class, 'createGeneratePdf'])
            ->name('worker.archive.genarte.tamplate.pdf.create');

        Route::post('contractor/archive/download/pdf', [Archive::class, 'tamplateGeneratePdf'])
            ->name('worker.archive.download.tamplate.pdf');

        Route::get('contractor/archive/generate/contract', [Archive::class, 'contractPdf'])
            ->name('worker.archive.download.empty.contract');

        Route::get('contractor/archive/fill/contract', [Archive::class, 'FillUgovor'])
            ->name('worker.archive.fill.contract');

        Route::post('contractor/archive/download/contract', [Archive::class, 'UgovorGeneratePDF'])
            ->name('worker.archive.download.contract');

        
        Route::middleware(['restrictUserAccess'])->group(function () {
            Route::get('contractor/archive/{id}', [Archive::class, 'selectedArchive'])
                ->name('worker.archive.selected');

            Route::get('contractor/view/pdf/{id}', [Archive::class, 'viewPDF'])
                ->name('worker.archive.view.pdf');

            Route::get('contractor/archive/select/contact/{id}', [Archive::class, 'selectContact'])
                ->name('worker.archive.select.contact');

            Route::get('contractor/{lice}/{id}', [Archive::class, 'showLice'])
                ->name('worker.archive.select.method');

            Route::get('contractor/show/{lice}/{method}/{id}', [Archive::class, 'contactOrForm'])
                ->name('worker.archive.show.lica');
        });
    
    });
});



