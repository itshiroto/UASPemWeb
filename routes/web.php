<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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


Route::get('/categories', [CategoryController::class, 'getAll']);
Route::get('/categories/{id}', [CategoryController::class, 'getById']);
Route::post('/categories/create', [CategoryController::class, 'create']);
Route::put('/categories/update/{id}', [CategoryController::class, 'update']);


// category crud
Route::get('/categories', [CategoryController::class, 'getAll']);
Route::get('/categories/{id}', [CategoryController::class, 'getById']);
Route::post('/categories/create', [CategoryController::class, 'create']);
Route::put('/categories/update/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);

Route::get('/check', [UserController::class, 'isLoggedIn']);


// get csrf token
Route::get('/csrf', function () {
    return csrf_token();
});
