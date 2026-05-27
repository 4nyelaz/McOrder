<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Closure-based route example
Route::get('/greeting', function () {
    return 'Welcome to McOrder!';
});

// Route with parameter example
Route::get('/menu/{id}', function (string $id) {
    return 'Menu with ID ' . $id;
});

// Home page (named route)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard redirects to menus index after login
Route::get('/dashboard', [MenuController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Protected routes — only authenticated users can access
Route::middleware('auth')->group(function () {

    // Breeze profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu routes — only index and show are needed
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');

    // Order routes
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';