<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Personnel;
use App\Models\Pressing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->gestionnaire) {
            return $this->gestionnaireStats();
        }
        return $this->personnelStats();
    }

    private function gestionnaireStats()
    {
        // Statistiques globales
        $stats = [
            'total_commandes' => Commande::count(),
            'commandes_en_cours' => Commande::whereIn('etat', ['En_attente', 'En_souffrance'])->count(),
            'ca_jour' => Commande::whereDate('created_at', Carbon::today())
                ->sum('montant_total'),
            'ca_semaine' => Commande::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->sum('montant_total'),
            'ca_mois' => Commande::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->sum('montant_total'),

            // Répartition par type de facturation
            // 'commandes_kilo' => Commande::whereHas('typeFacturation', function($q) {
            //     $q->where('libelle', 'like', '%kilo%');
            // })->count(),

            // 'commandes_vetement' => Commande::whereHas('typeFacturation', function($q) {
            //     $q->where('libelle', 'not like', '%kilo%');
            // })->count(),

            // Progression (comparaison avec le mois précédent)
            'progression' => $this->calculateProgression()
        ];

        // Alertes
        $alertes = $this->getAlertes();

        // Performance des employés
        $performances = Personnel::withCount(['commandes' => function($q) {
            $q->whereMonth('created_at', Carbon::now()->month);
        }])->get();

        return view('dashboard.dashboard', compact('stats', 'alertes', 'performances'));
    }

    public function getStats()
    {
        $stats = [
            'commandes_kilo' => Commande::whereHas('typeFacturation', function ($q) {
                $q->where('libelle', 'like', '%kilo%');
            })->count(),

            'commandes_vetement' => Commande::whereHas('typeFacturation', function ($q) {
                $q->where('libelle', 'not like', '%kilo%');
            })->count(),
        ];

        return response()->json($stats);
    }

    private function personnelStats()
    {
        $user = Auth::user();
        $personnel = $user->personnel;
        // Commandes du jour pour ce personnel
        $commandes_jour = Commande::where('personnel_id', $personnel->personnel_id)
            ->whereDate('created_at', Carbon::today())
            ->with(['client.user', 'typePrestation'])
            ->get();

        // Tâches en cours
        $taches = Commande::where('personnel_id', $personnel->personnel_id)
            ->where('etat', '!=', 'Livré')
            ->with(['client.user', 'typePrestation'])
            ->orderBy('date_reception', 'asc')
            ->get();

        return view('dashboard.dashboard', compact('commandes_jour', 'taches'));
    }

    private function calculateProgression()
    {
        $thisMonth = Commande::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonth = Commande::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        if ($lastMonth == 0) return "100%";

        $progression = (($thisMonth - $lastMonth) / $lastMonth) * 100;
        return round($progression, 1) . '%';
    }

    private function getAlertes()
    {
        $alertes = [];

        // Commandes en retard
        $retards = Commande::where('date_livraison', '<', Carbon::now())
            ->where('etat', '!=', 'Livré')
            ->count();
        if ($retards > 0) {
            $alertes[] = "$retards commande(s) en retard de livraison";
        }

        // Commandes en souffrance
        $souffrance = Commande::where('etat', 'En_souffrance')->count();
        if ($souffrance > 0) {
            $alertes[] = "$souffrance commande(s) en souffrance";
        }

        return $alertes;
    }
}
