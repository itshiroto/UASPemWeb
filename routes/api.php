<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\shoppingCartController;


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

Route::get('/unauthorized', function () {
    return response()->json([
        'message' => 'Unauthorized'
    ], 401);
})->name('unauthorized');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/users', [UserController::class, 'isLoggedIn'])->middleware('auth:sanctum');


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

// shopping cart
Route::post('/cart/add', [shoppingCartController::class, 'addToCart'])->middleware('auth:sanctum');
Route::get('/cart', [shoppingCartController::class, 'getCart'])->middleware('auth:sanctum');;
Route::post('/cart/update/{id}', [shoppingCartController::class, 'updateCart']);
Route::delete('/cart/delete/{id}', [shoppingCartController::class, 'deleteCart']);


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

// get csrf token
Route::get('/csrf', function () {
    return csrf_token();
});
