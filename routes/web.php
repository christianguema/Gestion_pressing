<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PressingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeFacturationController;
use App\Http\Controllers\TypePrestationController;
use App\Http\Controllers\VetementController;
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



//Routes pour la gestion du pressing

Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource('pressings', PressingController::class);
});


//Routes pour gérer le typeFacturation

Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource('type_facturations', TypeFacturationController::class);
});

//Routes pour gérer le typePrestation


Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource('type_prestations', TypePrestationController::class);
});

//Routes pour gérer les catégories


Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource('categories', CategorieController::class);
});

//Routes pour gérer les vêtements


Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
   Route::resource('vetements', VetementController::class);
});



// route des cas d'utilisation du personnel
Route::middleware(['auth'])->prefix('personnels')->group(function () {
    
    Route::get('/commandes/pending', [CommandeController::class, 'index'])->name('commandes.pendingIndex');
    Route::get('/commandes/{id}/etiquette', [CommandeController::class, 'generateLabels'])->name('commandes.downloadEtiquette');
    Route::patch('/commandes/{id}/change-status', [CommandeController::class, 'changeStatus'])->name('commandes.changeStatus');
    Route::post('/paiements', [PaiementController::class, 'storePaiement'])->name('paiements.store');
    Route::resource("commandes", CommandeController::class)->middleware("role:personnel");

    
});



require __DIR__.'/auth.php';
