<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth', 'role:gestionnaire'])->prefix('gestionnaire')->group(function () {
    Route::resource("personnel", PersonnelController::class);
});

// route des cas d'utilisation du personnel
Route::middleware(['auth', 'role:personnel'])->prefix('personnel')->group(function () {
    Route::resource("commandes", CommandeController::class);
});

require __DIR__.'/auth.php';
