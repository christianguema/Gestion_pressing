<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Remise;
use Illuminate\Http\Request;
use Ismaelw\LaraTeX\LaraTeX;
use Nette\Utils\Random;

class PaiementController extends Controller
{
    public function index()
    {
        // Logique pour récupérer la liste des paiements
        $paiements = Paiement::all();

        return view('paiements.index', compact('paiements'));
    }

    public function create() {

        // Logique pour afficher le formulaire de création de paiement
        $commandes = Commande::all();
        return view('paiements.create', compact('commandes'));

    }
    /**
     * Affiche le formulaire de paiement pour une commande.
     */
    public function showPaiementForm($commandeId)
    {
        // Logique pour récupérer la commande et les détails nécessaires
        // $commande = Commande::findOrFail($commandeId);

        return view('paiements.form', compact('commandeId'));
    }

    /**
     * Enregistre le paiement pour une commande.
     */
    public function storePaiement(Request $request, Paiement $paiement)
    {
        // Logique pour enregistrer le paiement
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string|max:255',
            'commande_id' => 'required|exists:commandes,commande_id',
            'date_paiement' => 'required|date',
        ]);

        $commande = Commande::findOrFail($request->input('commande_id'));

        $paiement = Paiement::create([
            'montant' => $request->input('montant'),
            'mode_paiement' => $request->input('mode_paiement'),
            'date_paiement' => $request->input('date_paiement'),
            'commande_id' => $request->input('commande_id'),
            'reference_transaction' => Random::generate(10, '0-9'),
        ]);

        $commande->paiement_id = $paiement->paiement_id;
        $commande->update();

        return redirect()->route('commandes.index')->with('success', 'Paiement enregistré avec succès.');
    }

    public function facturePaiement($commandeId)
    {
        // Logique pour générer la facture PDF du paiement
        $commande = Commande::findOrFail($commandeId);
        $paiement = $commande->paiement;
        if (!$paiement) {
            return redirect()->back()->with('error', 'Aucun paiement trouvé pour cette commande.');
        }
        $remise = Remise::find($commande->remise_id);
        $montantApresRemise = $commande->montant_total;
        $montantRemise = 0;
        $montantAvantRemise = 0;
        if($remise) {
            if($remise->type_remise === 'pourcentage') {
                $montantAvantRemise = $montantApresRemise * 100 / (100 - $remise->valeur);
                $montantRemise = $montantAvantRemise - $montantApresRemise;
            } else {
                $montantRemise = $remise->valeur;
            }
        }
        // dd($montantAvantRemise);
        $data = [
            'montant_avant' => $montantAvantRemise,
            'montant_remise' => $montantRemise,
            'commande' => $commande,
            'paiement' => $paiement,
        ];

        // Générer le PDF de la facture ici
        $pdf = (new LaraTeX('factures.facture-pdf'))->with($data);

        return $pdf->download('facture_paiement_' . $commandeId . '.pdf');
    }
}
