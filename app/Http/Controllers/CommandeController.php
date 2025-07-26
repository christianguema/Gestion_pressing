<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Pressing;
use App\Models\TypeFacturation;
use App\Models\TypePrestation;
use App\Models\User;
use App\Models\Vetement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{

    public function endIndex(Request $request)
    {
        $filter = $request->get('filter');
        $query = Commande::query();

        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère l'id du personnel lié à l'utilisateur
        $personnelId = $user->personnel->personnel_id ?? null;

        // Filtre par personnel connecté
        if ($personnelId) {
            $query->where('personnel_id', $personnelId);
        }

        // Filtre par période
        if ($filter === 'today') {
            $query->whereDate('date_reception', Carbon::today());
        } elseif ($filter === 'yesterday') {
            $query->whereDate('date_reception', Carbon::yesterday())->where('etat', 'Terminé');
        } elseif ($filter === 'last_week') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ])->where('etat', 'Terminé');
        } elseif ($filter === 'last_month') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->where('etat', 'Terminé');
        }

        $commandes = $query->get();

        return view('commandes.endIndex', compact('commandes', 'filter'));
    }

    public function pendingIndex(Request $request)
    {
        $filter = $request->get('filter');
        $query = Commande::query();

        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère l'id du personnel lié à l'utilisateur
        $personnelId = $user->personnel->personnel_id ?? null;

        // Filtre par personnel connecté
        if ($personnelId) {
            $query->where('personnel_id', $personnelId);
        }

        // Filtre par période
        if ($filter === 'today') {
            $query->whereDate('date_reception', Carbon::today());
        } elseif ($filter === 'yesterday') {
            $query->whereDate('date_reception', Carbon::yesterday())->where('etat', 'En_attente');
        } elseif ($filter === 'last_week') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ])->where('etat', 'En_attente');
        } elseif ($filter === 'last_month') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->where('etat', 'En_attente');
        }

        $commandes = $query->get();

        return view('commandes.pendingIndex', compact('commandes', 'filter'));
    }

    public function deleveredIndex()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère l'id du personnel lié à l'utilisateur
        $personnelId = $user->personnel->personnel_id ?? null;

        // Récupère les commandes livrées par le personnel connecté
        $commandes = Commande::where('etat', 'Livré')
            ->where('personnel_id', $personnelId)
            ->get();

        return view('commandes.deleveredIndex', compact('commandes'));
    }


    public function notdeliveredIndex()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère l'id du personnel lié à l'utilisateur
        $personnelId = $user->personnel->personnel_id ?? null;

        // Récupère les commandes non livrées par le personnel connecté
        $commandes = Commande::where('etat', 'Non_livré')
            ->where('personnel_id', $personnelId)
            ->get();

        return view('commandes.notDeleveredIndex', compact('commandes'));
    }


    public function create()
    {
        // Logique pour afficher le formulaire de création de commande
        $clients = Client::with("user")->get();
        $pressings = Pressing::all();
        $typeFacturations = TypeFacturation::all();
        $typePrestations = TypePrestation::all();
        $vetements = Vetement::all();
        return view('commandes.create', compact('clients', 'pressings', 'vetements', 'typeFacturations', 'typePrestations'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Création ou sélection du client
            if ($request->filled('client_id')) {
                $client_id = $request->input('client_id');
            } else {
                $user = User::create([
                    'name' => $request->input('name'),
                    'last_name' => $request->input('last_name'),
                    'contact' => $request->input('contact'),
                    'email' => $request->input('email'),
                ]);
                $client = Client::create([
                    'client_id' => $user->id,
                ]);
                $client_id = $client->client_id;
            }

            // Calcul du montant total
            $montant_total = 0;
            $typeFacturation = TypeFacturation::find($request->input('type_facturation_id'));
            if ($typeFacturation && str_contains(strtolower($typeFacturation->libelle), 'kilo')) {
                $montant_total = ($request->input('poids_total') ?? 0) * ($request->input('prix_unitaire_kilo') ?? 0);
            } elseif ($request->has('vetements')) {
                foreach ($request->input('vetements') as $vetement) {
                    $quantite = $vetement['quantite'] ?? 1;
                    $prix_unitaire = $vetement['prix_unitaire'] ?? 0;
                    $montant_total += $quantite * $prix_unitaire;
                }
            }

            // 2. Création de la commande
            $commande = Commande::create([
                'client_id' => $client_id,
                'pressing_id' => $request->input('pressing_id'),
                'personnel_id' => $request->input('personnel_id'),
                'type_facturation_id' => $request->input('type_facturation_id'),
                'type_prestation_id' => $request->input('type_prestation_id'),
                'date_reception' => $request->input('date_reception'),
                'date_livraison' => $request->input('date_livraison') ?? now()->addDays(3),
                'etat' => 'En_attente',
                'poids_total' => $request->input('poids_total'),
                'prix_unitaire_kilo' => $request->input('prix_unitaire_kilo'),
                'montant_total' => $montant_total,
            ]);

            // Ajout des lignes de commande
            if ($request->has('vetements')) {
                foreach ($request->input('vetements') as $vetement) {
                    $commande->vetements()->attach($vetement['vetement_id'] ?? null, [
                        'quantite' => $vetement['quantite'] ?? 1,
                        'couleur_vetement' => $vetement['couleur_vetement'] ?? null,
                        'prix_unitaire' => $vetement['prix_unitaire'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('commandes.pendingIndex')->with('success', 'Commande enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('commandes.create')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande : ' . $e->getMessage())->withInput();
        }
    }
}
