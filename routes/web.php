<?php

use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PressingController;
use App\Http\Controllers\ProfileController;
use App\Models\Personnel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('acceuil.welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route de gestion des profils
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/deleteImage', [ProfileController::class, 'deleteImage'])->name('profil.deleteImage');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route des cas d'utilisation du gestionnaire

Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource("personnels", PersonnelController::class);
});

// route des cas d'utilisation du personnel


//Routes pour la gestion du pressing

// Route::resource('pressings', PressingController::class);

Route::prefix('pressings')->name('pressings.')->group(function () {
    Route::get('/', [PressingController::class, 'index'])->name('index');
    Route::get('/create', [PressingController::class, 'create'])->name('create');
    Route::post('/', [PressingController::class, 'store'])->name('store');
    Route::get('/{pressing}', [PressingController::class, 'show'])->name('show');
    Route::get('/{pressing}/edit', [PressingController::class, 'edit'])->name('edit');
    Route::put('/{pressing}', [PressingController::class, 'update'])->name('update');
    Route::delete('/{pressing}', [PressingController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
