<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\ModePaiement;
use App\Models\Paiement;
use App\Models\Remise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ismaelw\LaraTeX\LaraTeX;
use Nette\Utils\Random;

class PaiementController extends Controller
{

    public function modePaiement()
    {
        $modes = ModePaiement::all();
        return response()->json($modes);
    }

    public function index()
    {
        // Logique pour récupérer la liste des paiements
        $paiements = Paiement::all();

        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {

        // Logique pour afficher le formulaire de création de paiement
        //Commande qui n'a pas encore été payée
        $commandes = Commande::whereDoesntHave('paiement')->get();
        $modes = ModePaiement::all();
        return view('paiements.create', compact('commandes', 'modes'));
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
    public function storePaiement(Request $request)
    {
        //dd($request->all());
        // Logique pour enregistrer le paiement
        $validated = $request->validate([
            'commande_id' => 'required|exists:commandes,commande_id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement_id' => 'required|exists:mode_paiements,mode_paiement_id',
            'date_paiement' => 'required|date',
            'reference_transaction' => 'string|nullable'
        ]);
        //dd($validated);
        try {
            DB::beginTransaction();

            $paiement = Paiement::create([
                'commande_id' => $validated['commande_id'],
                'montant' => $validated['montant'],
                'mode_paiement_id' => $validated['mode_paiement_id'],
                'date_paiement' => $validated['date_paiement'],
                'reference_transaction' => $validated['reference_transaction'] ?? null
            ]);


            DB::commit();
            return back()->with('success', 'Paiement enregistré avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement du paiement ' . $e->getMessage())->withInput();
        }
    }


    public function facturePaiement($commandeId)
    {
        // Logique pour générer la facture PDF du paiement
        $commande = Commande::findOrFail($commandeId);
        $paiement = $commande->paiement;
        $num_fac = 'FAC-' . strtoupper(Random::generate(8));
        $date = $commande->paiement->date_paiement;
        $nom_press = $commande->pressing->nom;
        if (!$paiement) {
            return redirect()->back()->with('error', 'Aucun paiement trouvé pour cette commande.');
        }
        $remise = Remise::find($commande->remise_id);
        $montantApresRemise = $commande->montant_total;
        $montantRemise = 0;
        $montantAvantRemise = 0;
        if ($remise) {
            if ($remise->type_remise === 'pourcentage') {
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
            'num_facture' => $num_fac,
            'date_paiement' => $date,
            'nom_pressing' => $nom_press,
            'commande' => $commande,
            'paiement' => $paiement,
        ];

        // Générer le PDF de la facture ici
        $pdf = (new LaraTeX('factures.facture-pdf'))->with($data);

        return $pdf->download('facture_paiement_' . $commandeId . '.pdf');
    }
}
