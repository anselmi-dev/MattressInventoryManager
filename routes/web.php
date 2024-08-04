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
            Route::get('/m/{model?}', \App\Livewire\Dimensions\ModelDimension::class)->name('model');
        });

        Route::middleware([])->prefix('fundas')->name('covers.')->group(function () {
            Route::get('/', \App\Livewire\Covers\IndexCovers::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Covers\ModelCover::class)->name('model');
        });

        Route::middleware([])->prefix('tapas')->name('tops.')->group(function () {
            Route::get('/', \App\Livewire\Tops\IndexTops::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Tops\ModelTop::class)->name('model');
        });

        Route::middleware([])->prefix('colchones')->name('mattresses.')->group(function () {
            Route::get('/', \App\Livewire\Mattresses\IndexMattresses::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Mattresses\ModelMattress::class)->name('model');
        });

        Route::middleware([])->prefix('combinaciones')->name('combinations.')->group(function () {
            Route::get('/', \App\Livewire\Combinations\IndexCombinations::class)->name('index');
            Route::get('/m/{model?}', \App\Livewire\Combinations\ModelCombination::class)->name('model');
        });
    });
});
