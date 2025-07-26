<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Pressing;
use App\Models\TypeFacturation;
use App\Models\TypePrestation;
use App\Models\Vetement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function create()
    {
        // Logique pour afficher le formulaire de création de commande
        $clients = Client::with('user')->get();
        $pressings = Pressing::all();
        $typeFacturations = TypeFacturation::all();
        $typePrestations = TypePrestation::all();
        $vetements = Vetement::all();
        return view('commandes.create', compact('clients', 'pressings','vetements' ,'typeFacturations', 'typePrestations'));
    }
}