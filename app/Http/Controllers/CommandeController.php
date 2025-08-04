<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Pressing;
use App\Models\Remise;
use App\Models\TypeFacturation;
use App\Models\TypePrestation;
use App\Models\User;
use App\Models\Vetement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ismaelw\LaraTeX\LaraTeX;

class CommandeController extends Controller
{

    // public function endIndex(Request $request)
    // {
    //     $filter = $request->get('filter');
    //     $query = Commande::query();

    //     // Récupère l'utilisateur connecté
    //     $user = Auth::user();

    //     // Récupère l'id du personnel lié à l'utilisateur
    //     $personnelId = $user->personnel->personnel_id ?? null;

    //     // Filtre par personnel connecté
    //     if ($personnelId) {
    //         $query->where('personnel_id', $personnelId);
    //     }

    //     // Filtre par période
    //     if ($filter === 'today') {
    //         $query->whereDate('date_reception', Carbon::today());
    //     } elseif ($filter === 'yesterday') {
    //         $query->whereDate('date_reception', Carbon::yesterday())->where('etat', 'Terminé');
    //     } elseif ($filter === 'last_week') {
    //         $query->whereBetween('date_reception', [
    //             Carbon::now()->subWeek()->startOfWeek(),
    //             Carbon::now()->subWeek()->endOfWeek()
    //         ])->where('etat', 'Terminé');
    //     } elseif ($filter === 'last_month') {
    //         $query->whereBetween('date_reception', [
    //             Carbon::now()->subMonth()->startOfMonth(),
    //             Carbon::now()->subMonth()->endOfMonth()
    //         ])->where('etat', 'Terminé');
    //     }

    //     $commandes = $query->get();

    //     return view('commandes.endIndex', compact('commandes', 'filter'));
    // }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $status = $request->get('status', 'En_attente');
        $pressingId = $request->get('pressing_id');

        $query = Commande::query();

        $user = Auth::user();
        $personnelId = $user->personnel->personnel_id ?? null;
        $personnelPressingId = $user->personnel->pressing_id ?? null;

        // Si personnel connecté, ne voir que les commandes de son pressing
        if ($personnelId && $personnelPressingId) {
            $query->where('pressing_id', $personnelPressingId);
        } elseif ($pressingId) {
            $query->where('pressing_id', $pressingId);
        }

        // Filtre par statut
        if ($status) {
            $query->where('etat', $status);
        }

        // Filtre par période
        if ($filter === 'today') {
            $query->whereDate('date_reception', Carbon::today());
        } elseif ($filter === 'yesterday') {
            $query->whereDate('date_reception', Carbon::yesterday());
        } elseif ($filter === 'last_week') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ]);
        } elseif ($filter === 'last_month') {
            $query->whereBetween('date_reception', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ]);
        }

        $commandes = $query->orderBy('date_reception', 'asc')->get();
        $pressings = Pressing::all();
        $statuses = ['En_attente', 'Livré', 'Terminé', 'En_souffrance'];

        return view('commandes.index', compact('commandes', 'filter', 'status', 'pressings', 'statuses', 'pressingId'));
    }

    // public function pendingIndex(Request $request)
    // {
    //     $filter = $request->get('filter');
    //     $query = Commande::query();

    //     // Récupère l'utilisateur connecté
    //     $user = Auth::user();

    //     // Récupère l'id du personnel lié à l'utilisateur
    //     $personnelId = $user->personnel->personnel_id ?? null;

    //     // Filtre par personnel connecté
    //     if ($personnelId) {
    //         $query->where('personnel_id', $personnelId);
    //     }

    //     // Filtre par période
    //     if ($filter === 'today') {
    //         $query->whereDate('date_reception', Carbon::today());
    //     } elseif ($filter === 'yesterday') {
    //         $query->whereDate('date_reception', Carbon::yesterday())->where('etat', 'En_attente');
    //     } elseif ($filter === 'last_week') {
    //         $query->whereBetween('date_reception', [
    //             Carbon::now()->subWeek()->startOfWeek(),
    //             Carbon::now()->subWeek()->endOfWeek()
    //         ])->where('etat', 'En_attente');
    //     } elseif ($filter === 'last_month') {
    //         $query->whereBetween('date_reception', [
    //             Carbon::now()->subMonth()->startOfMonth(),
    //             Carbon::now()->subMonth()->endOfMonth()
    //         ])->where('etat', 'En_attente');
    //     }

    //     $commandes = $query->get();

    //     return view('commandes.index', compact('commandes', 'filter'));
    // }

    // public function deleveredIndex()
    // {
    //     // Récupère l'utilisateur connecté
    //     $user = Auth::user();

    //     // Récupère l'id du personnel lié à l'utilisateur
    //     $personnelId = $user->personnel->personnel_id ?? null;

    //     // Récupère les commandes livrées par le personnel connecté
    //     $commandes = Commande::where('etat', 'Livré')
    //         ->where('personnel_id', $personnelId)
    //         ->get();

    //     return view('commandes.deleveredIndex', compact('commandes'));
    // }


    // public function notdeliveredIndex()
    // {
    //     // Récupère l'utilisateur connecté
    //     $user = Auth::user();

    //     // Récupère l'id du personnel lié à l'utilisateur
    //     $personnelId = $user->personnel->personnel_id ?? null;

    //     // Récupère les commandes non livrées par le personnel connecté
    //     $commandes = Commande::where('etat', 'Non_livré')
    //         ->where('personnel_id', $personnelId)
    //         ->get();

    //     return view('commandes.notDeleveredIndex', compact('commandes'));
    // }


    public function create()
    {
        // Logique pour afficher le formulaire de création de commande
        $clients = Client::with("user")->get();
        $pressings = Pressing::all();
        $typeFacturations = TypeFacturation::all();
        $typePrestations = TypePrestation::all();
        $vetements = Vetement::all();
        $remises = Remise::all();
        return view('commandes.create', compact('clients', 'pressings', 'vetements', 'typeFacturations', 'typePrestations', 'remises'));
    }

    public function store(Request $request)
    {
        try {
            //dd($request->all());
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

            //gestion des remises
            $remise = null;
            if ($request->filled('remise_id')) {
                $remise = Remise::find($request->input('remise_id'));
                if ($remise) {
                    if ($remise->type_remise === 'pourcentage') {
                        $montant_total -= ($montant_total * $remise->valeur / 100);
                    } elseif ($remise->type_remise === 'fixe') {
                        $montant_total -= $remise->valeur;
                    }
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
                'remise_id' => $request->input('remise_id') ? $request->input('remise_id') : null,
                'date_livraison' => $request->input('date_livraison') ? Carbon::parse($request->input('date_livraison'))->addDays($typeFacturation->duree_moyenne) : now()->addDays(3),
                'etat' => 'En_attente',
                'poids_total' => $request->input('poids_total'),
                'prix_unitaire_kilo' => $request->input('prix_unitaire_kilo'),
                'montant_total' => $montant_total,
            ]);

            // Ajout des lignes de commande (table pivot commande_vetement)
            if ($request->has('vetements')) {
                foreach ($request->input('vetements') as $vetement) {
                    // Pour la facturation par kilo, on ne prend pas en compte prix_unitaire
                    $pivotData = [
                        'quantite' => $vetement['quantite'] ?? 1,
                        'description' => $vetement['description'] ?? null,
                    ];
                    if ($typeFacturation && str_contains(strtolower($typeFacturation->libelle), 'vetement')) {
                        $pivotData['prix_unitaire'] = $vetement['prix_unitaire'] ?? null;
                    }
                    $commande->vetements()->attach($vetement['vetement_id'] ?? null, $pivotData);
                }
            }

            DB::commit();
            return redirect()->route('commandes.pendingIndex')->with('success', 'Commande enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('commandes.create')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande : ' . $e->getMessage())->withInput();
        }
    }

    public function show(Commande $commande)
    {
        // Logique pour afficher les détails d'une commande
        $commande->load('client', 'pressing', 'personnel', 'typeFacturation', 'typePrestation', 'vetements');
        $vetements = $commande->vetements;
        $remise = Remise::find($commande->remise_id);
        $montantApresRemise = $commande->montant_total;
        $montantRemise = 0;
        if($remise) {
            if($remise->type_remise === 'pourcentage') {
                $montantAvantRemise = $montantApresRemise * 100 / (100 - $remise->valeur);
                $montantRemise = $montantAvantRemise - $montantApresRemise;
            } else {
                $montantRemise = $remise->valeur;
            }
        }
        $statuses = ['Livré', 'Terminé', 'En_souffrance'];
        return view('commandes.show', compact('commande', 'vetements', 'remise', 'statuses','montantRemise'));
    }

    public function changeStatus(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $request->validate([
            'status' => 'required|in:En_attente,Livré,Terminé,En_souffrance',
        ]);

        $commande->etat = $request->input('status');
        $commande->update();
        // Générer des étiquettes si le statut est changé
        $this->generateLabels($commande);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    //function pour générer des étiquettes a chaque fois que le statut de la commande change de statut
    public function generateLabels(Commande $commande)
    {
        // Charger les relations nécessaires
        $commande->load('client.user', 'vetements');

        // Préparer les données pour le template LaTeX
        $data = [
            'commande_id' => $commande->commande_id,
            'client_nom' => $commande->client->user->name . ' ' . $commande->client->user->last_name,
            'date_reception' => $commande->date_reception,
            'etat' => $commande->etat,
            'vetements' => $commande->vetements,
        ];

        // Générer le PDF avec LaraTeX
        $pdf = (new LaraTeX('etiquettes.etiquette-pdf'))->with($data);

        // Retourner le PDF à télécharger
        return $pdf->download('etiquette_commande_' . $commande->commande_id . '.pdf');
    }

    
    // public function download(){
    //     return (new LaraTeX)->dryRun();
    // }
}

