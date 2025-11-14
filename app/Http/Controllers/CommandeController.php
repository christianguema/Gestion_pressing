<?php

namespace App\Http\Controllers;

use App\Mail\CommandeTerminee;
use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeVetement;
use App\Models\Pressing;
use App\Models\Remise;
use App\Models\TypeFacturation;
use App\Models\TypePrestation;
use App\Models\User;
use App\Models\Vetement;
use Carbon\Carbon;
use DragonCode\Contracts\Cashier\Config\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ismaelw\LaraTeX\LaraTeX;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $status = $request->get('status', 'En_attente');
        $pressingId = $request->get('pressing_id');
        $search = $request->get('search');


        $query = Commande::query();

        if ($search) {
            // Nettoyer la recherche
            $searchTerm = trim($search);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('numero_ticket', 'LIKE', "%{$searchTerm}%")
                    // Recherche exacte
                    ->orWhere('numero_ticket', '=', $searchTerm);
            });
            // Log plus détaillé avec la requête finale
            $sql = str_replace(['?'], ['\'%'.$search.'%\''], $query->toSql());
            Log::info('Recherche commande détaillée:', [
                'terme_recherché' => $search,
                'requête_complète' => $sql,
                'nombre_résultats' => $query->count()
            ]);
            // Désactiver les autres filtres si une recherche est en cours
            $filter = null;
            $status = null;
        }

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
        } elseif ($filter === 'in_week') {
            $query->whereBetween('date_reception', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($filter === "in_month") {
            $query->whereBetween('date_reception', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }

        $commandes = $query->orderBy('date_reception', 'asc')->get();
        $pressings = Pressing::all();
        $statuses = ['En_attente', 'Livré', 'Terminé', 'En_souffrance', 'Partiellement'];
        $nextStatuses = [
            'En_attente' => ['Livré', 'Terminé', 'En_souffrance'],
            'Livré' => [],
            'Terminé' => ['Livré', 'En_souffrance'],
            // 'Partiellement' => ['Livré', 'En_souffrance'],
            'En_souffrance' => ['Livré'],
        ];

        return view('commandes.index', compact('commandes', 'filter', 'status', 'pressings', 'statuses', 'nextStatuses', 'pressingId','search'));
    }

    public function create()
    {
        // Logique pour afficher le formulaire de création de commande
        $clients = Client::with("user")->get();
        $pressings = Pressing::all();
        $typeFacturations = TypeFacturation::all();
        $typePrestations = TypePrestation::all();
        //tous les vetements et leur catégorie associé
        $vetements = Vetement::with('categorie')->get();
        $remises = Remise::all();
        return view('commandes.create', compact('clients', 'pressings', 'vetements', 'typeFacturations', 'typePrestations', 'remises'));
    }

    private function generateTicketNumber($client_contact)
    {
        // Récupérer la dernière commande
        $lastCommande = Commande::latest()->first();

        // Extraire le numéro de séquence de la dernière commande ou commencer à 1
        $lastNumber = 1;
        if ($lastCommande && $lastCommande->numero_ticket) {
            preg_match('/CMD(\d{3})-/', $lastCommande->numero_ticket, $matches);
            if (isset($matches[1])) {
                $lastNumber = intval($matches[1]) + 1;
            }
        }

        // Formater le numéro de séquence sur 3 chiffres
        $sequence = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        // Formater la date (YYMMDD)
        $date = now()->format('ymd');

        // Nettoyer le contact (enlever les espaces et caractères spéciaux)
        $contact = preg_replace('/[^0-9]/', '', $client_contact);

        // Générer le numéro de ticket
        return "CMD{$sequence}-{$date}-{$contact}";
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {
            //dd($request->all());

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

            // Générer le numéro de ticket
            $contact = $request->filled('client_id')
                ? Client::find($request->input('client_id'))->user->contact
                : $request->input('contact');

            $numero_ticket = $this->generateTicketNumber($contact);

            //Log::info('recupération du client');

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

            //Log::info("Calul du montant");

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
                'numero_ticket' => $numero_ticket,
                'remise_id' => $request->input('remise_id') ? $request->input('remise_id') : null,
                'date_livraison' => $request->input('date_livraison') ? Carbon::parse($request->input('date_livraison'))->addDays($typeFacturation->duree_moyenne) : now()->addDays(3),
                'etat' => 'En_attente',
                'poids_total' => $request->input('poids_total'),
                'prix_unitaire_kilo' => $request->input('prix_unitaire_kilo'),
                'montant_total' => $montant_total,
            ]);

            //Log::info('enregistrement de la commande');
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
            return redirect()->route('commandes.pendingIndex')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande : ' . $e->getMessage())->withInput();
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
        if ($remise) {
            if ($remise->type_remise === 'pourcentage') {
                $montantAvantRemise = $montantApresRemise * 100 / (100 - $remise->valeur);
                $montantRemise = $montantAvantRemise - $montantApresRemise;
            } else {
                $montantRemise = $remise->valeur;
            }
        }
        $nextStatuses = [
            'En_attente' => ['Livré', 'Terminé', 'En_souffrance', 'Partiellement'],
            'Livré' => [],
            'Terminé' => ['Livré', 'En_souffrance', 'Partiellement'],
            'Partiellement' => ['Livré', 'En_souffrance', 'Partiellement'],
            'En_souffrance' => ['Livré', 'Partiellement', 'Partiellement'],
        ];
        return view('commandes.show', compact('commande', 'vetements', 'remise', 'nextStatuses', 'montantRemise'));
    }

    public function changeStatus(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $etatActuel = $commande->etat;
        $nouvelEtat = $request->input('status');
        $transitions = [
            'En_attente'    => ['Livré', 'Terminé', 'En_souffrance'],
            'En_souffrance' => ['Livré', 'Terminé', 'Partiellement'],
            'Partiellement' => ['Livré', 'Terminé', 'En_souffrance'],
            'Terminé'       => ['Livré', 'En_souffrance', 'Partiellement'],
            'Livré'         => [],
        ];
        $request->validate([
            'status' => 'required|in:En_attente,Livré,Terminé,En_souffrance',
        ]);
        if (!in_array($nouvelEtat, $transitions[$etatActuel] ?? [])) {
            return back()->with('error', 'Transition de statut non autorisée.');
        }

        if ($commande->etat === 'Terminé') {
            $email = $commande->client->user->email;
            if ($email) {
                Mail::to($email)->send(new CommandeTerminee($commande));
            }
        }

        $commande->etat = $nouvelEtat;
        $commande->update();
        // Générer des étiquettes si le statut est changé


        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    public function facture(Commande $commande)
    {
        //Logique pour concevoir la facture d'une

        return view('commandes.facture', compact('commande', 'vetements', 'remise', 'montantRemise'));
    }

    //function pour générer des étiquettes a chaque fois que le statut de la commande change de statut
    public function generateLabels($id)
    {
        $commande = Commande::findOrFail($id);
        // Charger les relations nécessaires
        $commande->load('client.user', 'vetements');

        // Préparer les données pour le template LaTeX
        $data = [
            'commande_id' => $commande->commande_id,
            'client_nom' => $commande->client->user->name . ' ' . $commande->client->user->last_name,
            'client_contact' => $commande->client->user->contact,
            'date_livraison' => $commande->date_livraison,
            'date_reception' => $commande->date_reception,
            'etat' => $commande->etat,
            'numero_ticket' => $commande->numero_ticket,
            'vetements' => $commande->vetements,
        ];

        // Générer le PDF avec LaraTeX
        $pdf = (new LaraTeX('etiquettes.etiquette-pdf'))->with($data);

        // Retourner le PDF à télécharger
        return $pdf->download('etiquette_commande_' . $commande->commande_id . '.pdf');
    }

    public function updateLivraisonPartielle(Request $request, Commande $commande)
    {
        DB::beginTransaction();
        try {
            $livraisons = $request->input('livraisons', []);
            $toutLivre = true;

            foreach ($livraisons as $vetementId => $quantiteLivree) {
                $vetement = $commande->vetements()->where('vetement_id', $vetementId)->first();
                if (!$vetement) continue;

                $nouvelleQuantiteLivree = $vetement->pivot->quantite_livree + $quantiteLivree;
                $commande->vetements()->updateExistingPivot($vetementId, [
                    'quantite_livree' => $nouvelleQuantiteLivree
                ]);

                if ($nouvelleQuantiteLivree < $vetement->pivot->quantite) {
                    $toutLivre = false;
                }
            }

            // Si tout est livré, on passe la commande en état "Livré"
            if ($toutLivre) {
                $commande->etat = 'Livré';
                $commande->save();
            }

            DB::commit();
            return back()->with('success', 'Livraison partielle enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement de la livraison partielle.');
        }
    }

    // public function listVetement($id)
    // {
    //     // Récupérer la commande avec ses vêtements
    //     $lignes = CommandeVetement::with('vetement:vetement_id,type')
    //     ->where('commande_id', $id)
    //     ->get()
    //     ->map(function ($ligne) {
    //         return [
    //             'vetement_id' => $ligne->vetement_id,
    //             'type' => $ligne->vetement->type,
    //             'pivot' => [
    //                 'quantite' => $ligne->quantite,
    //                 'quantite_livree' => $ligne->quantite_livree
    //             ]
    //         ];
    //     });

    //     return response()->json($lignes);
    // }

}
