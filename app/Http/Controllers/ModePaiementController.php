<?php

namespace App\Http\Controllers;

use App\Models\ModePaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModePaiementController extends Controller
{
    public function index()
    {
        $mode_paiements = ModePaiement::all();
        return view("mode_paiement.index", compact("mode_paiements"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validation
            $validate = $request->validate([
                'nom' => 'required|string|max:255',
                'telephone' => 'nullable|string|max:20',
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Traitement du logo
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoPath = $logo->store('modes_paiement', 'public');
            }

            // Création du mode de paiement
            ModePaiement::create([
                'nom' => $validate['nom'],
                'telephone' => $validate['telephone'],
                'logo' => $logoPath ?? null
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Mode de paiement ajouté avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $modePaiement = ModePaiement::findOrFail($id);

            // Validation
            $validate = $request->validate([
                'nom' => 'required|string|max:255',
                'telephone' => 'nullable|string|max:20',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Traitement du logo
            if ($request->hasFile('logo')) {
                // Supprimer l'ancien logo
                if ($modePaiement->logo) {
                    Storage::disk('public')->delete($modePaiement->logo);
                }

                // Sauvegarder le nouveau logo
                $logo = $request->file('logo');
                $logoPath = $logo->store('modes_paiement', 'public');
                $validate['logo'] = $logoPath;
            }

            // Mise à jour
            $modePaiement->update([
                'nom' => $validate['nom'],
                'telephone' => $validate['telephone'],
                'logo' => $validate['logo'] ?? $modePaiement->logo
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Mode de paiement modifié avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la modification: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $modePaiement = ModePaiement::findOrFail($id);

            // Supprimer le logo
            if ($modePaiement->logo) {
                Storage::disk('public')->delete($modePaiement->logo);
            }

            // Supprimer le mode de paiement
            $modePaiement->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Mode de paiement supprimé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
