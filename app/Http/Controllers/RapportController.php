<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\RapportsPerformance;
use App\Models\Pressing;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Ismaelw\LaraTeX\LaraTeX;

class RapportController extends Controller
{
    /**
     * Affiche la liste des rapports avec filtres
     */
    public function index(Request $request)
    {
        try {
            $pressingId = $request->get('pressing_id');
            $type = $request->get('type', 'journalier');
            $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

            $query = RapportsPerformance::with('pressing');

            if ($pressingId) {
                $query->where('pressing_id', $pressingId);
            }

            // Définition des périodes selon le type
            switch ($type) {
                case 'hebdomadaire':
                    $start = $date->copy()->startOfWeek();
                    $end = $date->copy()->endOfWeek();
                    $query->whereBetween('periode', [$start, $end]);
                    $title = "Rapport Hebdomadaire du " . $start->format('d/m/Y') . " au " . $end->format('d/m/Y');
                    break;

                case 'mensuel':
                    $query->whereYear('periode', $date->year)
                        ->whereMonth('periode', $date->month);
                    $title = "Rapport Mensuel - " . $date->format('F Y');
                    break;

                default:
                    $query->whereDate('periode', $date->toDateString());
                    $title = "Rapport Journalier du " . $date->format('d/m/Y');
            }

            $rapports = $query->orderBy('periode', 'desc')->get();

            // Préparation des données pour le graphique
            $labels = $rapports->pluck('periode')
                ->map(function($date) {
                    return Carbon::parse($date)->format('d/m');
                })
                ->toArray();

            $revenus = $rapports->pluck('revenus')->toArray();
            $commandes = $rapports->pluck('nombre_commande')->toArray();

            $pressings = Pressing::all();

            return view('rapports.index', compact(
                'rapports',
                'title',
                'labels',
                'revenus',
                'commandes',
                'pressings',
                'pressingId',
                'type',
                'date'
            ));

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des rapports : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors du chargement des rapports.');
        }
    }

    /**
     * Exporte les rapports en PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $data = $this->getDataForExport($request);

            if (empty($data['rapports']) || $data['rapports']->isEmpty()) {
                return back()->with('error', 'Aucune donnée à exporter pour cette période.');
            }

            $pdf = (new LaraTeX("rapports.rapport_pdf"))->with($data);
            $filename = 'rapport-' . now()->format('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'export PDF : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'export PDF.');
        }
    }

    /**
     * Affiche le formulaire de génération manuelle
     */
    public function genererManuelForm()
    {
        $pressings = Pressing::all();
        return view('rapports.generer_manuel', compact('pressings'));
    }

    /**
     * Génère un rapport pour un pressing spécifique
     */
    public function rapportParPressing(Pressing $pressing, Request $request)
    {
        try {
            $type = $request->get('type', 'journalier');
            $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

            $query = RapportsPerformance::where('pressing_id', $pressing->pressing_id);

            switch ($type) {
                case 'hebdomadaire':
                    $start = $date->copy()->startOfWeek();
                    $end = $date->copy()->endOfWeek();
                    $query->whereBetween('periode', [$start, $end]);
                    $title = "Rapport Hebdomadaire - {$pressing->nom}, {$pressing->adresse} ({$start->format('d/m/Y')} au {$end->format('d/m/Y')})";
                    break;

                case 'mensuel':
                    $query->whereYear('periode', $date->year)
                        ->whereMonth('periode', $date->month);
                    $title = "Rapport Mensuel - {$pressing->nom}, {$pressing->adresse} ({$date->format('F Y')})";
                    break;

                default:
                    $query->whereDate('periode', $date->toDateString());
                    $title = "Rapport Journalier - {$pressing->nom}, {$pressing->adresse} ({$date->format('d/m/Y')})";
            }

            $rapports = $query->orderBy('periode', 'desc')->get();

            // Données pour le graphique
            $labels = $rapports->pluck('periode')->map(function($date) {
                return Carbon::parse($date)->format('d/m/Y');
            })->toArray();

            $revenus = $rapports->pluck('revenus')->toArray();
            $commandes = $rapports->pluck('nombre_commande')->toArray();

            return view('rapports.par_pressing', compact(
                'pressing',
                'rapports',
                'title',
                'labels',
                'revenus',
                'commandes',
                'type',
                'date'
            ));

        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du rapport par pressing : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la génération du rapport.');
        }
    }

    /**
     * Traite la génération manuelle de rapports
     */
    public function genererManuelTraitement(Request $request)
    {
        try {
            $request->validate([
                'pressing_id' => 'nullable|exists:pressings,pressing_id',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
            ]);

            $debut = Carbon::parse($request->date_debut);
            $fin = Carbon::parse($request->date_fin);
            $pressingId = $request->pressing_id;

            // Vérification de la plage de dates (max 1 an)
            if ($debut->diffInDays($fin) > 365) {
                return back()->with('error', 'La période ne peut pas dépasser 1 an.');
            }

            $pressings = $pressingId ? [Pressing::find($pressingId)] : Pressing::all();
            $rapportsCrees = 0;

            foreach ($pressings as $pressing) {
                for ($date = $debut->copy(); $date->lessThanOrEqualTo($fin); $date->addDay()) {

                    // Vérifier si le rapport existe déjà
                    $rapportExistant = RapportsPerformance::where('pressing_id', $pressing->pressing_id)
                        ->whereDate('periode', $date->format('Y-m-d'))
                        ->first();

                    if ($rapportExistant) {
                        continue; // Passer au jour suivant
                    }

                    // Calculer le nombre de commandes pour cette date
                    $nombreCommandes = Commande::where('pressing_id', $pressing->pressing_id)
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->count();

                    // Calculer les revenus (commandes livrées avec paiement)
                    $revenus = Commande::where('pressing_id', $pressing->pressing_id)
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->where('etat', 'Livré')
                        ->whereHas('paiement')
                        ->with('paiement')
                        ->get()
                        ->sum(function ($commande) {
                            return $commande->paiement->montant ?? 0;
                        });

                    // Créer le rapport seulement s'il y a des données
                    if ($nombreCommandes > 0 || $revenus > 0) {
                        RapportsPerformance::create([
                            'pressing_id' => $pressing->pressing_id,
                            'periode' => $date->format('Y-m-d'),
                            'nombre_commande' => $nombreCommandes,
                            'revenus' => $revenus,
                        ]);

                        $rapportsCrees++;
                    }
                }
            }

            $dateDebut = $debut->format('d/m/Y');
            $dateFin = $fin->format('d/m/Y');

            if ($rapportsCrees > 0) {
                return redirect()->route('rapports.index')
                    ->with('success', "$rapportsCrees rapports générés entre $dateDebut et $dateFin.");
            } else {
                return redirect()->route('rapports.index')
                    ->with('info', "Aucun nouveau rapport à créer pour la période du $dateDebut au $dateFin.");
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération manuelle : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la génération des rapports.');
        }
    }

    /**
     * Récupère les données pour l'export (méthode privée corrigée)
     */
    private function getDataForExport(Request $request)
    {
        $pressingId = $request->get('pressing_id');
        $type = $request->get('type', 'journalier');
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $query = RapportsPerformance::with('pressing');

        if ($pressingId) {
            $query->where('pressing_id', $pressingId);
        }

        // Construction du titre et des filtres
        $pressingInfo = null;
        if ($pressingId) {
            $pressingInfo = Pressing::find($pressingId);
        }

        switch ($type) {
            case 'hebdomadaire':
                $start = $date->copy()->startOfWeek();
                $end = $date->copy()->endOfWeek();
                $query->whereBetween('periode', [$start, $end]);

                $title = $pressingInfo
                    ? "Rapport Hebdomadaire - {$pressingInfo->nom}, {$pressingInfo->adresse} ({$start->format('d/m/Y')} - {$end->format('d/m/Y')})"
                    : "Rapport Hebdomadaire Global ({$start->format('d/m/Y')} - {$end->format('d/m/Y')})";
                break;

            case 'mensuel':
                $query->whereYear('periode', $date->year)
                      ->whereMonth('periode', $date->month);

                $title = $pressingInfo
                    ? "Rapport Mensuel - {$pressingInfo->nom}, {$pressingInfo->adresse} ({$date->format('F Y')})"
                    : "Rapport Mensuel Global ({$date->format('F Y')})";
                break;

            default:
                $query->whereDate('periode', $date->toDateString());

                $title = $pressingInfo
                    ? "Rapport Journalier - {$pressingInfo->nom}, {$pressingInfo->adresse} ({$date->format('d/m/Y')})"
                    : "Rapport Journalier Global ({$date->format('d/m/Y')})";
        }

        return [
            'rapports' => $query->orderBy('periode', 'desc')->get(),
            'title' => $title,
            'pressing' => $pressingInfo,
            'type' => $type,
            'date' => $date,
        ];
    }

    /**
     * Méthode utilitaire pour nettoyer les anciens rapports (optionnel)
     */
    public function nettoyerAncienRapports()
    {
        try {
            // Supprimer les rapports de plus de 2 ans
            $dateLimit = Carbon::now()->subYears(2);

            $supprime = RapportsPerformance::where('periode', '<', $dateLimit)->delete();

            return response()->json([
                'success' => true,
                'message' => "$supprime anciens rapports supprimés."
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du nettoyage : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du nettoyage.'
            ]);
        }
    }
}
