@extends('layouts.base')


@section('title', 'Commandes')

{{-- @php
    $vetementsPayload = collect(); // On initialise une collection vide

    foreach ($commandes as $commande) {
        foreach ($commande->vetements as $v) {
            $vetementsPayload->push([
                'type'            => $v->type,
                'quantite'        => (int) ($v->pivot->quantite ?? 0),
                'quantite_livree' => (int) ($v->pivot->quantite_livree ?? 0),
                'vetement_id'     => (int) $v->vetement_id,
            ]);
        }
    }
    // dd(json_encode($vetementsPayload));
    // Si tu veux t'assurer que les index sont réinitialisés comme avec ->values()
    $vetementsPayload = $vetementsPayload->values();
@endphp --}}


@section('content')

@if (session('success'))
@include('components.alertModals.success')
@endif

@if (session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES COMMANDES</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('commandes.pendingIndex') }}">Commandes</a></li>
            <li class="breadcrumb-item active">Attentes</li>
        </ol>
    </nav>
</div>


<div class="mb-3 d-flex justify-content-between align-items-center">
    @role('personnel')
    <a href="{{ route('commandes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Enregistrer
    </a>
    @endrole
    {{-- <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Filtrer par période
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item"
                    href="{{ route('commandes.pendingIndex', ['filter' => 'today']) }}">Aujourd'hui</a>
            </li>
            <li><a class="dropdown-item"
                    href="{{ route('commandes.pendingIndex', ['filter' => 'yesterday']) }}">Hier</a></li>
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'last_week']) }}">Semaine
                    passée</a></li>
            <li><a class="dropdown-item" href="{{ route('commandes.pendingIndex', ['filter' => 'last_month']) }}">Mois
                    passé</a></li>
        </ul>
    </div> --}}

    <form method="GET" action="{{ route('commandes.pendingIndex') }}" class="gap-2 d-flex">
        @role('gestionnaire')
        <select name="pressing_id" class="form-select" style="width:auto;" @if(Auth::user()->personnel) disabled @endif>
            <option value="">Tous les pressings</option>
            @foreach($pressings as $pressing)
            <option value="{{ $pressing->pressing_id }}" {{ (request('pressing_id', $pressingId)==$pressing->
                pressing_id) ?
                'selected' : '' }}>
                {{ $pressing->nom }}
            </option>
            @endforeach
        </select>
        @endrole

        <select name="status" class="form-select" style="width:auto;">
            @foreach($statuses as $s)
            <option value="{{ $s }}" {{ (request('status', $status)==$s) ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
        <select name="filter" class="form-select" style="width:auto;">
            <option value="today" {{ $filter=='today' ? 'selected' : '' }}>Aujourd'hui</option>
            <option value="yesterday" {{ $filter=='yesterday' ? 'selected' : '' }}>Hier</option>
            <option value="last_week" {{ $filter=='last_week' ? 'selected' : '' }}>Semaine passée</option>
            <option value="in_week" {{ $filter=='in_week' ? 'selected' : '' }}>Dans la semaine</option>
            <option value="last_month" {{ $filter=='last_month' ? 'selected' : '' }}>Mois passé</option>
        </select>
        <button type="submit" class="btn btn-outline-primary">Filtrer</button>
    </form>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom Client</th>
                                @role('gestionnaire')
                                    <th>Pressing</th>
                                @endrole
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
                                @role('gestionnaire')
                                    <td>{{ $commande->pressing->nom }}</td>
                                @endrole
                                <td>{{ $commande->date_reception ?
                                    \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $commande->date_livraison ?
                                    \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $commande->montant_total ?? '-' }} FCFA</td>
                                <td>
                                    @if($commande->etat == 'En_attente')
                                    <span class="badge rounded-pill bg-primary">En attente</span>
                                    @elseif($commande->etat == 'Livré')
                                    <span class="badge rounded-pill bg-success text-dark">Livrée</span>
                                    @elseif($commande->etat == 'Terminé')
                                    <span class="badge rounded-pill bg-info">Terminée</span>
                                    @elseif($commande->etat == 'En_souffrance')
                                    <span class="badge rounded-pill bg-warning">En souffrance</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Liste actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('commandes.show', $commande->commande_id) }}"
                                                    class="dropdown-item btn-info">
                                                    <i class="bi bi-eye"></i> Details
                                                </a>
                                            </li>
                                            @if($commande->etat !== 'Livré' && $commande->etat !== 'Terminé' &&
                                            !isset($commande->paiement))
                                            <li>
                                                <button data-id="{{ $commande->commande_id }}"
                                                    data-montant="{{ $commande->montant_total }}"
                                                    class="dropdown-item btn-primary btn-card btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#payementCard">
                                                    <i class="bi bi-credit-card"></i> Paiement
                                                </button>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('commandes.downloadEtiquette', $commande->commande_id) }}"
                                                    class="dropdown-item btn-warning">
                                                    <i class="bi bi-file-earmark-pdf"></i> Etiquette
                                                </a>
                                            </li>

                                            @role('personnel')
                                                @if($commande->paiement)
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                @foreach($nextStatuses[$commande->etat] ?? [] as $s)
                                                <li>
                                                    <form method="POST" action="{{ route('commandes.changeStatus', $commande->commande_id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $s }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-arrow-repeat"></i> Marquer comme {{ $s }}
                                                        </button>
                                                    </form>
                                                </li>
                                                @endforeach

                                                {{-- @if($commande->etat != "Livré")
                                                    <li>
                                                        <button type="button" class="dropdown-item btn-partiellement" data-bs-toggle="modal"
                                                            data-bs-target="#livraisonPartielleModal" data-commande-id="{{ $commande->commande_id }}"
                                                            data-vetements="{{ json_encode($vetementsPayload) }}">
                                                            <i class="bi bi-arrow-repeat"></i> Marquer comme Partiellement
                                                        </button>
                                                    </li>
                                                @endif --}}

                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    {{-- telecharger la facture --}}
                                                    <a href="{{ route('paiements.facture', $commande->commande_id) }}"
                                                        class="dropdown-item btn-success">
                                                        <i class="bi bi-file-earmark-pdf"></i> Télécharger la Facture
                                                    </a>
                                                </li>
                                                @endif
                                            @endrole
                                        </ul>
                                    </div>
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
@include('components.modals.partiellement.partiellement')
@include('components.modals.payementCard.payementModal')
@endsection
