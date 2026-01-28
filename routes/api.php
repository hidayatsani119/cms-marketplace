<?php

use App\Http\Controllers\UserController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductQrCodeController;
use Illuminate\Support\Facades\Route;

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
//users public route
Route::post('users', [UserController::class, 'login']);
Route::post("qr/{qr_token}", [ProductQrCodeController::class, 'verify']);

//product public route
Route::get('products', [ProductController::class, 'getAll']);
Route::get('products/search/', [ProductController::class, 'search']);
Route::get("products/{product_id}", [ProductController::class, 'get']);

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(callback: function () {
    //users
    Route::get('users', [UserController::class, 'get']);
    Route::delete('users', [UserController::class, 'logout']);
    //products
    Route::post('products', [ProductController::class, 'create']);
    Route::put("products/{product_id}", [ProductController::class, 'update']);
    Route::delete("products/{product_id}", [ProductController::class, 'delete']);
    //products-qr-code
    Route::post("products/{product_id}/qr-code", [ProductQrCodeController::class, 'create']);
   });
