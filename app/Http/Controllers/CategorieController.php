<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        $categories = Categorie::orderBy('intitule')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire d'ajout.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string|max:255|unique:categories,intitule',
        ]);

        Categorie::create($request->only('intitule'));

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    /**
     * Affiche les détails d'une catégorie.
     */
    public function show(Categorie $categorie)
    {
        return view('categories.show', compact('categorie'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Vérification si la catégorie existe
        if (!$categorie) {
            return redirect()->route('categories.index')->with('error', 'Catégorie non trouvée.');
        }
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Met à jour une catégorie.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->only('intitule'));

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour.');
    }

    /**
     * Supprime une catégorie.
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Vérification si la catégorie est utilisée par des vêtements
        if ($categorie->vetements()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Cette catégorie est utilisée par des vêtements et ne peut pas être supprimée.');
        }

        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée.');
    }
}
