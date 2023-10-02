<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route User
Route::post('/user/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::apiResource('user', \App\Http\Controllers\UserController::class)->middleware('auth:sanctum');
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware('auth:sanctum');

// Route Product
Route::apiResource('product', \App\Http\Controllers\ProductController::class)->middleware('auth:sanctum');

// Route Category
Route::apiResource('category', \App\Http\Controllers\CategoryController::class)->middleware('auth:sanctum');

// Route Payment
Route::apiResource('payment', \App\Http\Controllers\PaymentController::class)->middleware('auth:sanctum');

