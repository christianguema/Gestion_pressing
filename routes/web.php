<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModePaiementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PressingController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RemiseController;
use App\Http\Controllers\TypeFacturationController;
use App\Http\Controllers\TypePrestationController;
use App\Http\Controllers\VetementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('acceuil.welcome');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get("personnel/accompte",[PersonnelController::class,"compte"])->name("personnels.compte");
    Route::patch('/personnels/{personnel}/update-account', [PersonnelController::class,'updateAccount'])
        ->name('personnels.updateAccount')
        ->middleware('can:manage-accounts');

    Route::patch('/personnels/{personnel}/update-roles', [PersonnelController::class, 'updateRoles'])
    ->name('personnels.updateRoles')
    ->middleware('can:manage-accounts');
    Route::get('/rapport/performance', [RapportController::class,'performanceRepport'])->name('rapports.performance');
    Route::get('/rapport', [RapportController::class,'repport'])->name('rapports.repports');
    Route::resource('vetements', VetementController::class);
    Route::resource('remises', RemiseController::class);
    Route::resource('categories', CategorieController::class);
    Route::get('/dashboard/statistiques', [DashboardController::class, 'getStats'])
    ->name('dashboard.stats');

    Route::get('/mode_paiements', [ModePaiementController::class, 'index'])->name('mode_paiements.index');
    Route::post('/mode_paiements', [ModePaiementController::class, 'store'])->name('mode_paiements.store');
    Route::put('/mode_paiements/{id}', [ModePaiementController::class, 'update'])->name('mode_paiements.update');
    Route::delete('/mode_paiements/{id}', [ModePaiementController::class, 'destroy'])->name('mode_paiements.destroy');
});


// route des cas d'utilisation du personnel
Route::middleware(['auth'])->prefix('personnel')->group(function () {
    Route::get('/commandes/pending', [CommandeController::class, 'index'])->name('commandes.pendingIndex');
    Route::get('/commandes/{id}/etiquette', [CommandeController::class, 'generateLabels'])->name('commandes.downloadEtiquette');
    Route::patch('/commandes/{id}/change-status', [CommandeController::class, 'changeStatus'])->name('commandes.changeStatus');
    Route::post('/paiements', [PaiementController::class, 'storePaiement'])->name('paiements.store');

    Route::get('/modes-paiement', [PaiementController::class, 'modePaiement']);

    Route::get('/paiement/create',[PaiementController::class, 'create'])->name('paiements.create');
    Route::get('/commandes/{commandeId}/facture', [PaiementController::class, 'facturePaiement'])->name('paiements.facture');
    Route::patch('/commandes/{commandeId}/livraison-partielle', [CommandeController::class, 'updateLivraisonPartielle'])->name('commandes.updateLivraisonPartielle');

    Route::get('/commandes/{id}/vetements', [CommandeController::class,'listVetement']);
    // Route::get('commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::resource("commandes", CommandeController::class)->middleware("role:personnel");
});

require __DIR__.'/auth.php';
