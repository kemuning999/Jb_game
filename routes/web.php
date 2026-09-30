<?php

use App\Http\Controllers\BuatQrisController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// BuatQris Webhook (Excluded from CSRF in bootstrap/app.php)
Route::post('/buatqris/webhook', [BuatQrisController::class, 'handleWebhook'])->name('buatqris.webhook');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Checkout
    Route::get('/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{slug}', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order_number}/status', [OrderController::class, 'checkStatus'])->name('orders.status');
    Route::post('/orders/{order_number}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order_number}/simulate-pay', [BuatQrisController::class, 'simulatePay'])->name('orders.simulate-pay');

    // Dashboard redirects to orders
    Route::get('/dashboard', function () {
        return redirect()->route('orders.index');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
