<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TiffinRecipeController;
use App\Http\Controllers\CreateKitchenController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//Route::post('/logout', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});


Route::get('/getAllUsers', [UserController::class, 'getAllUsers']);
Route::get('/getAllCustomers', [UserController::class, 'getAllCustomers']);
Route::get('/getAllSellers', [UserController::class, 'getAllSellers']);

Route::get('/users/{id}', [UserController::class, 'getUserById']);


// Route::put('/emailverified/{id}', function (Request $request, $id) {
//     return (new UserController())->updateEmailVerified($id);
// });

// Retrieve all banner images
Route::get('/banners', [BannersController::class, 'index']);


Route::get('categories', [CategoryController::class, 'index']);

Route::get('tiffinrecipes', [TiffinRecipeController::class, 'index']);

Route::post('/posttiffin', [TiffinRecipeController::class, 'store']);

Route::get('gettiffins', [TiffinRecipeController::class, 'gettiffins']);

Route::delete('/deletetiffin/{id}', [TiffinRecipeController::class, 'deletetiffin']);

Route::put('/tiffin/edit/{id}', [TiffinRecipeController::class, 'editTiffin']);

Route::post('/kitchens', [CreateKitchenController::class, 'create'])->name('kitchens.create');
Route::get('getallkitchens', [CreateKitchenController::class, 'getAllKitchens']);
Route::get('kitchen',  [CreateKitchenController::class, 'getKitchenByUserId']);
Route::delete('/deletekitchen/{id}', [CreateKitchenController::class, 'deleteKitchen']);

Route::post('/chat/store', [ChatController::class, 'storeChat']);

// Fetch chat messages
Route::get('/chat/fetch', [ChatController::class, 'fetchChat']);