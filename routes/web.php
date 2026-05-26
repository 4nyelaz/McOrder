<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Closure-based route (ruta simple)
Route::get('/greeting', function () {
    return 'Welcome to McOrder!';
});

// Ruta con parámetro
Route::get('/menu/{id}', function (string $id) {
    return 'Menu with ID ' . $id;
});

// Página de inicio (nombrada)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta con order
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/dashboard', [MenuController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas de perfil de Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de menús (controller-based + resource)
    Route::resource('menus', MenuController::class);

    // Rutas de ingredientes (nombradas)
    Route::get('menus/{menu}/ingredients/create', [IngredientController::class, 'create'])
        ->name('ingredients.create');
    Route::post('menus/{menu}/ingredients', [IngredientController::class, 'store'])
        ->name('ingredients.store');
    Route::delete('menus/{menu}/ingredients/{ingredient}', [IngredientController::class, 'destroy'])
        ->name('ingredients.destroy');
});

require __DIR__.'/auth.php';