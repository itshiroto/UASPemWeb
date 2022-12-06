<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/admin', [UserController::class, 'adminPage']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [UserController::class, 'logout']);
});


// product crud
Route::get('/products', [ProductController::class, 'getAll']);
Route::get('/products/{id}', [ProductController::class, 'getById']);
Route::post('/products/create', [ProductController::class, 'create']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);
Route::delete('/products/delete/{id}', [ProductController::class, 'delete']);
Route::get('/products/category/{id}', [ProductController::class, 'getByCategory']);

// category crud
Route::get('/categories', [CategoryController::class, 'getAll']);
Route::post('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);

Route::get('/check', [UserController::class, 'isLoggedIn']);


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
