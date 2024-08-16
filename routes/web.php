<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        Route::get('/', \App\Livewire\Dashboard::class)->name('dashboard');
    
        Route::middleware([])->prefix('medidas')->name('dimensions.')->group(function () {
            Route::get('/', \App\Livewire\Dimensions\IndexDimensions::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Dimensions\ModelDimension::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('partes')->name('products.')->group(function () {
            Route::get('/', \App\Livewire\Products\IndexProducts::class)->name('index');
            Route::get('/p/{model?}', \App\Livewire\Products\ModelProduct::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('combinaciones')->name('combinations.')->group(function () {
            Route::get('/', \App\Livewire\Combinations\IndexCombinations::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Combinations\ModelCombination::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('issues')->name('issues.')->group(function () {
            Route::get('/', \App\Livewire\Issues\IndexIssues::class)->name('index');
            Route::get('/i/{model?}', \App\Livewire\Issues\ModelIssue::class)->middleware(['role:develop|admin'])->name('model');
        });

        Route::middleware([])->prefix('users')->name('users.')->middleware(['role:develop|admin'])->group(function () {
            Route::get('/', \App\Livewire\Users\IndexUsers::class)->name('index');
            Route::get('/u/{model?}', \App\Livewire\Users\ModelUser::class)->name('model');
        });

        Route::middleware([])->prefix('ventas')->name('sales.')->group(function () {
            Route::get('/', \App\Livewire\Sales\IndexSales::class)->name('index');
        });

        Route::get('settings', \App\Livewire\Settings::class)->name('settings');

        Route::get('activity-log', \App\Livewire\ActivityLog::class)->name('activity.index');
    });
});
