<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
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


// get csrf token
Route::get('/csrf', function () {
    return csrf_token();
});
