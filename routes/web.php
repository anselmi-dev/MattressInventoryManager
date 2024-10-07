<?php

use Illuminate\Support\Facades\Route;

// VOLANA72X30
// REVISAR EL STOK
Route::middleware('auth')->group(function () {
    
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        Route::get('/', \App\Livewire\Dashboard::class)->name('dashboard');
        
        Route::middleware([])->prefix('medidas')->name('dimensions.')->group(function () {
            Route::get('/', \App\Livewire\Dimensions\IndexDimensions::class)->name('index');
            Route::get('/{model}', \App\Livewire\Dimensions\ShowDimension::class)->name('show');
            Route::get('/m/{model?}', \App\Livewire\Dimensions\ModelDimension::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('partes')->name('products.')->group(function () {
            Route::get('/', \App\Livewire\Products\IndexProducts::class)->name('index');
            Route::get('/{model}', \App\Livewire\Products\ShowProduct::class)->name('show');
            Route::get('/p/{model?}', \App\Livewire\Products\ModelProduct::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('combinaciones')->name('combinations.')->group(function () {
            Route::get('/', \App\Livewire\Combinations\IndexCombinations::class)->name('index');
            Route::get('/s/{model}', \App\Livewire\Combinations\IndexCombinations::class)->name('show');
            Route::get('/m/{model?}', \App\Livewire\Combinations\ModelCombination::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('issues')->name('issues.')->group(function () {
            Route::get('/', \App\Livewire\Issues\IndexIssues::class)->name('index');
            Route::get('/i/{model?}', \App\Livewire\Issues\ModelIssue::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('users')->name('users.')->middleware(['role:develop|admin'])->group(function () {
            Route::get('/', \App\Livewire\Users\IndexUsers::class)->name('index');
            Route::get('/{model?}', \App\Livewire\Users\ModelUser::class)->name('model');
        });
        
        Route::middleware([])->prefix('ordenes')->name('orders.')->group(function () {
            Route::get('/', \App\Livewire\Orders\IndexOrders::class)->name('index');
            Route::get('/{model}', \App\Livewire\Orders\ShowOrder::class)->name('show');
        });

        Route::middleware([])->prefix('ventas')->name('sales.')->group(function () {
            Route::get('/', \App\Livewire\Sales\IndexSales::class)->name('index');
            Route::get('/{model}', \App\Livewire\Sales\ShowSale::class)->name('show');
        });
        
        Route::middleware([])->prefix('fabricacion-de-medidas-especiales')->name('manufacture-special-measures.')->group(function () {
            Route::get('/', \App\Livewire\SpecialMeasures\IndexSpecialMeasures::class)->name('index');
        });

        Route::middleware([])->prefix('settings')->name('settings.')->group(function () {
            Route::get('/', \App\Livewire\Settings::class)->name('index');
        });

        Route::middleware([])->prefix('settings/tipo-productos')->name('product_types.')->group(function () {
            Route::get('/', \App\Livewire\ProductTypes\IndexProductTypes::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\ProductTypes\ModelProductTypes::class)->name('model');
        });
        

        Route::get('activity-log', \App\Livewire\ActivityLog::class)->name('activity.index');
    });
});
