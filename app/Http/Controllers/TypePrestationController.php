<?php

namespace App\Http\Controllers;

use App\Models\TypePrestation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TypePrestationController extends Controller
{
    /**
     * Liste tous les types de prestation.
     */
    public function index(): View
    {
        $typePrestations = TypePrestation::orderBy('intitule')->paginate(10);
        return view('type_prestations.index', compact('typePrestations'));
    }

    /**
     * Affiche le formulaire d'ajout.
     */
    public function create(): View
    {
        return view('type_prestations.create');
    }

    /**
     * Enregistre un nouveau type de prestation.
     */
    public function store(Request $request): RedirectResponse
    {
        //Ancien
        // $request->validate([
        //     'intitule' => 'required|string|max:255|unique:type_prestations,intitule',
        //     'duree_moyenne' => 'nullable|integer|min:0',
        // ]);

        //New
        $request->validate([
            'intitule' => 'required|string|max:255|unique:type_prestations,intitule',
            'duree_moyenne' => 'nullable|integer|min:0',
        ]);

        TypePrestation::create($request->only('intitule','duree_moyenne'));

        return redirect()->route('type_prestations.index')
            ->with('success', 'Type de prestation ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un type de prestation.
     */
    public function show(TypePrestation $typePrestation): View
    {
        return view('type_prestations.show', compact('typePrestation'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(TypePrestation $typePrestation): View
    {
        return view('type_prestations.edit', compact('typePrestation'));
    }

    /**
     * Met à jour un type de prestation.
     */
    public function update(Request $request, TypePrestation $typePrestation): RedirectResponse
    {
        $request->validate([
            'intitule' => 'required|string|max:255|unique:type_prestations,intitule,' . 
            $typePrestation->id,
            'duree_moyenne' => 'nullable|integer|min:0',
        ]);

        $typePrestation->update($request->only('intitule','duree_moyenne'));

        return redirect()->route('type_prestations.index')
            ->with('success', 'Type de prestation mis à jour.');
    }

    /**
     * Supprime un type de prestation.
     */
    public function destroy(TypePrestation $typePrestation)
    {
        // Optionnel : vérifier si le type est utilisé ailleurs
        // if ($typePrestation->commandes()->exists()) {
        //     return redirect()->route('type_prestations.index')
        //         ->with('error', 'Ce type de prestation est utilisé et ne peut pas être supprimé.');
        // }

        $typePrestation->delete();

        return redirect()->route('type_prestations.index')
            ->with('success', 'Type de prestation supprimé.');
    }
}