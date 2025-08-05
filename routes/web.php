<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PressingController;
use App\Http\Controllers\TypeFacturationController;
use App\Http\Controllers\TypePrestationController;
use App\Http\Controllers\VetementController;
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
    Route::resource('pressings', PressingController::class);
    Route::resource('type_prestations', TypePrestationController::class);
    Route::resource('type_facturations', TypeFacturationController::class);
    Route::resource("personnels", PersonnelController::class);
    Route::resource('vetements', VetementController::class);
    Route::resource('categories', CategorieController::class);
});


// route des cas d'utilisation du personnel
Route::middleware(['auth'])->prefix('personnel')->group(function () {
    //Route::get('/commandes/endIndex', [CommandeController::class, 'endIndex'])->name('commandes.endIndex');
    //Route::get('/commandes/delivered', [CommandeController::class, 'deleveredIndex'])->name('commandes.deliveredIndex');
    //Route::get('/commandes/notDelivered', [CommandeController::class, 'notDeliveredIndex'])->name('commandes.notDeliveredIndex');
    Route::get('/commandes/pending', [CommandeController::class, 'index'])->name('commandes.pendingIndex');
    Route::get('/commandes/{id}/etiquette', [CommandeController::class, 'generateLabels'])->name('commandes.downloadEtiquette');
    Route::patch('/commandes/{id}/change-status', [CommandeController::class, 'changeStatus'])->name('commandes.changeStatus');
    Route::post('/paiements', [PaiementController::class, 'storePaiement'])->name('paiements.store');
    Route::resource("commandes", CommandeController::class)->middleware("role:personnel");
});

require __DIR__.'/auth.php';
