<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TiffinRecipeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/upload', function () {
    return view('upload');
})->name('image.uploadform');

 Route::post('/upload', [App\Http\Controllers\BannersController::class, 'upload'])->name('image.upload');


Route::get('/categories/create', function () {
    return view('/categories/create');
})->name('image.uploadform');

Route::post('/categories/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');


Route::get('/tiffinrecipes/create', function () {
    return view('/tiffinrecipes/create');
})->name('image.uploadform');

Route::post('/tiffinrecipes/create', [App\Http\Controllers\TiffinRecipeController::class, 'store'])->name('tiffinrecipes.store');
