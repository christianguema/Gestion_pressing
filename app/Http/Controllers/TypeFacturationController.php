<?php
namespace App\Http\Controllers;

use App\Models\TypeFacturation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TypeFacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $typeFacturations = TypeFacturation::all();
        return view('type_facturations.index', compact('typeFacturations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('type_facturations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        TypeFacturation::create($validatedData);

        return redirect()->route('type_facturations.index')->with('success', 'Type de facturation ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeFacturation  $typeFacturation
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeFacturation $typeFacturation): View
    {
        return view('type_facturations.edit', compact('typeFacturation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeFacturation  $typeFacturation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeFacturation $typeFacturation): RedirectResponse
    {
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $typeFacturation->update($validatedData);

        return redirect()->route('type_facturations.index')->with('success', 'Type de facturation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeFacturation  $typeFacturation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeFacturation $typeFacturation): RedirectResponse
    {
        $typeFacturation->delete();

        return redirect()->route('type_facturations.index')->with('success', 'Type de facturation supprimé avec succès.');
    }
}