<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\RapportsPerformance;
use App\Models\Pressing;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf;
use Ismaelw\LaraTeX\LaraTeX as Pdf;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $pressingId = $request->get('pressing_id');
        $type = $request->get('type', 'journalier');
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $query = RapportsPerformance::with('pressing');

        if ($pressingId) {
            $query->where('pressing_id', $pressingId);
        }

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

        $labels = $rapports->pluck('periode')
            ->map(fn($date) => Carbon::parse($date)->format('d/m'))
            ->toArray();

        $revenus = $rapports->pluck('revenus')->toArray();

        //dump($revenus);
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
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getDataForExport($request);
        $pdf = new Pdf("rapports.rapport_pdf", $data);
        return $pdf->download('rapport-' . now()->format('Y/m/d') . '.pdf');
    }


    // Générer manuellement entre deux dates
    public function genererManuelForm()
    {
        $pressings = Pressing::all();
        return view('rapports.generer_manuel', compact('pressings'));
    }

    //Generer rapport par pressing
    public function rapportParPressing(Pressing $pressing, Request $request)
    {
        $type = $request->get('type', 'journalier');
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $query = RapportsPerformance::where('pressing_id', $pressing->pressing_id);

        switch ($type) {
            case 'hebdomadaire':
                $start = $date->copy()->startOfWeek();
                $end = $date->copy()->endOfWeek();
                $query->whereBetween('periode', [$start, $end]);
                $title = "Rapport Hebdomadaire - {$pressing->nom} , {$pressing->adresse} ({$start->format('d/m/Y')} au {$end->format('d/m/Y')})";
                break;

            case 'mensuel':
                $query->whereYear('periode', $date->year)
                    ->whereMonth('periode', $date->month);
                $title = "Rapport Mensuel - {$pressing->nom} , {$pressing->adresse} ({$date->format('F Y')})";
                break;

            default:
                $query->whereDate('periode', $date->toDateString());
                $title = "Rapport Journalier - {$pressing->nom} , {$pressing->adresse} ({$date->format('d/m/Y')})";
        }

        $rapports = $query->orderBy('periode', 'desc')->get();

        // Données pour le graphique
        $labels = $rapports->pluck('periode')->map->format('d/m/Y')->toArray();
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
    }

    private function getDataForExport(Request $request)
    {
        $pressingId = $request->get('pressing_id');
        $type = $request->get('type', 'journalier');
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $query = RapportsPerformance::with('pressing');

        if ($pressingId) {
            $query->where('pressing_id', $pressingId);
        }

        switch ($type) {
            case 'hebdomadaire':
                $start = $date->copy()->startOfWeek();
                $end = $date->copy()->endOfWeek();
                $query->whereBetween('periode', [$start, $end]);
                $title = $pressingId
                    ? "Rapport Hebdomadaire - {$query->first()?->pressing?->nom} , {$query->first()?->pressing?->adresse} ({$start->format('d/m/Y')} - {$end->format('d/m/Y')})"
                    : "Rapport Hebdomadaire Global ({$start->format('d/m')} - {$end->format('d/m/Y')})";
                break;

            case 'mensuel':
                $query->whereYear('periode', $date->year)->whereMonth('periode', $date->month);
                $title = $pressingId
                    ? "Rapport Mensuel - {$query->first()?->pressing?->nom} , {$query->first()?->pressing?->adresse} ({$date->format('F Y')})"
                    : "Rapport Mensuel Global ({$date->format('F Y')})";
                break;

            default:
                $query->whereDate('periode', $date->toDateString());
                $title = $pressingId
                    ? "Rapport Journalier - {$query->first()?->pressing?->nom} , {$query->first()?->pressing?->adresse} ({$date->format('d/m/Y')})"
                    : "Rapport Journalier Global ({$date->format('d/m/Y')})";
        }

        return [
            'rapports' => $query->get(),
            'title' => $title,
        ];
    }

    public function genererManuelTraitement(Request $request)
    {
        $request->validate([
            'pressing_id' => 'nullable|exists:pressings,pressing_id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $debut = Carbon::parse($request->date_debut);
        $fin = Carbon::parse($request->date_fin);
        $pressingId = $request->pressing_id;

        $dates = [];
        for ($date = $debut->copy(); $date->lessThanOrEqualTo($fin); $date->addDay()) {
            $dates[] = $date->format('Y/m/d');
        }

        $pressings = $pressingId ? [Pressing::find($pressingId)] : Pressing::all();
        $rapportsCrees = 0;

        foreach ($pressings as $pressing) {
            foreach ($dates as $date) {
                if (RapportsPerformance::where('pressing_id', $pressing->pressing_id)
                    ->whereDate('periode', $date)
                    ->exists()
                ) {
                    continue;
                }

                $nombreCommandes = Commande::where('pressing_id', $pressing->pressing_id)
                    ->whereDate('created_at', $date)
                    ->count();

                dump($nombreCommandes);
                $revenus = Commande::where('pressing_id', $pressing->pressing_id)
                ->whereDate('created_at', $date)
                ->whereIn('etat', ['Livré'])
                ->whereHas('paiement')
                ->with('paiement')
                ->get()
                ->sum(function($commande) {
                    return $commande->paiement->montant ?? 0;
                });

                dump($revenus);
                RapportsPerformance::create([
                    'pressing_id' => $pressing->pressing_id,
                    'periode' => $date,
                    'nombre_commande' => $nombreCommandes,
                    'revenus' => $revenus,
                ]);

                $rapportsCrees++;
            }
        }

        $dateDebut = $debut->format('d/m/Y');
        $dateFin = $fin->format('d/m/Y');

        return redirect()->route('rapports.index')
            ->with('success', "$rapportsCrees rapports générés entre $dateDebut et $dateFin.");
    }
}
