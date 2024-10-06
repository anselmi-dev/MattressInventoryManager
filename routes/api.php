<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/parts/index', [\App\Http\Controllers\Api\ProductController::class, 'parts'])->name('api.parts.index');