<?php
// app/Http/Controllers/PressingController.php

namespace App\Http\Controllers;

use App\Models\Pressing;
use Illuminate\Http\Request;

class PressingController extends Controller
{
    /**
     * Afficher la liste des pressings.
     */
    public function index()
    {
        $pressings = Pressing::all();
        return view('pressings.index', compact('pressings'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('pressings.create');
    }

    /**
     * Enregistrer un nouveau pressing.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
        ]);

        Pressing::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('pressings.index')->with('success', 'Pressing ajouté avec succès.');
    }

    /**
     * Afficher les détails d’un pressing.
     */
    public function show(Pressing $pressing){
        //compter le nombre de personnel, de commande et de rapport dans le pressing
        $pressing->loadCount(['personnels','commandes','rapportPerformance']);
        return view('pressings.show', compact('pressing'));
    }

    /**
     * Afficher le formulaire d’édition.
     */
    public function edit(Pressing $pressing)
    {
        return view('pressings.edit', compact('pressing'));
    }

    /**
     * Mettre à jour un pressing.
     */
    public function update(Request $request, Pressing $pressing)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
        ]);

        $pressing->update([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('pressings.index')->with('success', 'Pressing mis à jour.');
    }

    /**
     * Supprimer un pressing.
     */
    public function destroy(Pressing $pressing)
    {
        $pressing->loadCount(['personnels', 'commandes']);
        if ($pressing->personnels_count > 0 || $pressing->commandes_count > 0) {
    return back()->withErrors(['error' => 'Impossible de supprimer ce pressing : il contient des données associées.']);
}
        $pressing->delete();
        return redirect()->route('pressings.index')->with('success', 'Pressing supprimé.');
    }
}