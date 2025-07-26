@extends('layouts.base')


@section('title', 'Commandes')

@section('content')

@if (session('success'))
    @include('components.alertModals.success')
@endif

@if (session('error'))
    @include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES COMMANDES EN ATTENTES</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('commandes.pendingIndex') }}">Commandes</a></li>
            <li class="breadcrumb-item active">Attentes</li>
        </ol>
    </nav>
</div>


<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('commandes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Enregistrer
    </a>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Filtrer par période
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'today']) }}">Aujourd'hui</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'yesterday']) }}">Hier</a></li>
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'last_week']) }}">Semaine
                    passée</a></li>
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'last_month']) }}">Mois
                    passé</a></li>
        </ul>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    Nom Client
                                </th>
                                <th data-type="date" data-format="DD/MM/YYYY">Date Reception</th>
                                <th data-type="date" data-format="DD/MM/YYYY">Date Livraison</th>
                                <th>Montant</th>
                                <th>Etat</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandes as $commande)
                            <tr>
                                <td>{{ $commande->client?->user->name ?? '-' }}</td>
                                <td>{{ $commande->date_reception ?
                                    \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $commande->date_livraison ?
                                    \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $commande->montant_total ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-primary">En attente</span>
                                </td>
                                <td>
                                    <!-- Exemple d'action -->
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                    <a href="#" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Annuler
                                    </a>
                                    @role('gestionnaire')
                                        {{-- suppression --}}
                                    @endrole
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune commande trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
