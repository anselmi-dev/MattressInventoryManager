<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/parts/index', function (Request $request) {
    return \App\Models\Product::whereNotCombinations()->where('code', 'like', "%$request->search%")->orWhere('name', 'like', "%$request->search%")->get();
})->name('api.parts.index');