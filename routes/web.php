<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductPageController;
use App\Http\Controllers\Web\QrVerificationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductPageController::class, 'show'])->name('products.show');
Route::get('/verify', [QrVerificationController::class, 'index'])->name('verify');
Route::get('/verify/{token}', [QrVerificationController::class, 'verify'])->name('verify.token');

// Admin Routes
Route::prefix('admin')->group(function () {
    // Auth routes (guest)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    // Protected routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Categories
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);
        
        // Products
        Route::resource('products', AdminProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
        
        // QR Codes
        Route::get('/qr-codes', [QrCodeController::class, 'index'])->name('admin.qr-codes.index');
        Route::post('/qr-codes/{product}', [QrCodeController::class, 'store'])->name('admin.qr-codes.store');
        Route::delete('/qr-codes/{qrCode}', [QrCodeController::class, 'destroy'])->name('admin.qr-codes.destroy');
        
        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
    });
});
