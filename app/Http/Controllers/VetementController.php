<?php

namespace App\Http\Controllers;

use App\Models\Vetement;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VetementController extends Controller
{
    /**
     * Affiche la liste des vêtements.
     */
    // public function index(): View
    // {
    //     $vetements = Vetement::with('categorie')->orderBy('type')->paginate(10);
    //     return view('vetements.index', compact('vetements'));
    // }

    //Pour pouvoir filtrer par catégorie


    public function index(Request $request)
    {
        $query = Vetement::with('categorie');

        // Filtre par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Recherche dynamique (on la prépare aussi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('type', 'like', "%{$search}%");
        }

        $vetements = $query->orderBy('type')->paginate(10)->appends($request->query());

        // Pour le filtre
        $categories = Categorie::orderBy('intitule')->get();

        return view('vetements.index', compact('vetements', 'categories'));
    }

    /**
     * Affiche le formulaire d'ajout.
     */
    public function create(): View
    {
        $categories = Categorie::orderBy('intitule')->get();
        return view('vetements.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau vêtement.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'prix_unitaire' => 'nullable|numeric|min:0',
            'categorie_id' => 'required|exists:categories,categorie_id',
        ]);

        Vetement::create($request->only('type', 'prix_unitaire', 'categorie_id'));

        return redirect()->route('vetements.index')
            ->with('success', 'Vêtement ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un vêtement.
     */
    public function show(Vetement $vetement): View
    {
        return view('vetements.show', compact('vetement'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Vetement $vetement): View
    {
        $categories = Categorie::orderBy('intitule')->get();
        return view('vetements.edit', compact('vetement', 'categories'));
    }

    /**
     * Met à jour un vêtement.
     */
    public function update(Request $request, Vetement $vetement)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'prix_unitaire' => 'nullable|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $vetement->update($request->only('type', 'prix_unitaire', 'categorie_id'));

        return redirect()->route('vetements.index')
            ->with('success', 'Vêtement mis à jour.');
    }

    /**
     * Supprime un vêtement.
     */
    public function destroy(Vetement $vetement): RedirectResponse
    {
        $vetement->delete();

        return redirect()->route('vetements.index')
            ->with('success', 'Vêtement supprimé.');
    }
}
