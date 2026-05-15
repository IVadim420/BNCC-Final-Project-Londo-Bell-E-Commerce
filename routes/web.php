<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Middleware\SimpleAuth;

//User (/)
Route::middleware(SimpleAuth::class . ':user')->group(function() {
    Route::get('/', [ItemController::class, 'userPage'])->name('userPage');
});


//Admin (/admin)
Route::prefix('admin')->middleware(SimpleAuth::class . ':admin')->group(function() {
    Route::get('/', [ItemController::class, 'adminPage'])->name('admin.page');
    Route::get('/create', [ItemController::class, 'showCreate'])->name('showCreate');
    Route::post('/create', [ItemController::class, 'create'])->name('create');
    Route::get('/update/{id}', [ItemController::class, 'showUpdate'])->name('showUpdate');
    Route::patch('/update/{id}', [ItemController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ItemController::class, 'delete'])->name('delete');
});

//Cart

Route::get('/cart', [InvoiceController::class, 'cart']);
Route::post('/cart/add/{id}', [InvoiceController::class, 'addToCart']);
Route::post('/cart/update/{id}', [InvoiceController::class, 'updateCart']);
Route::post('/cart/remove/{id}', [InvoiceController::class, 'removeFromCart']);
Route::post('/checkout', [InvoiceController::class, 'checkout']);

//Invoice
Route::get('/invoice/{id}', [InvoiceController::class, 'show']);

require __DIR__.'/auth.php';
