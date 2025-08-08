@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')
<div class="pagetitle">
    <h1>Tableau de bord</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

@role('gestionnaire')
<section class="section dashboard">
    <div class="row">
        {{-- Stats Cards --}}
        <div class="col-12">
            <div class="row">
                {{-- Total Commandes --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Commandes Totales</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $stats['total_commandes'] ?? 0 }}</h6>
                                    <span class="pt-1 text-success small fw-bold">{{ $stats['progression'] ?? '0%' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chiffre d'affaires --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">CA Journalier</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($stats['ca_jour'] ?? 0, 0, ',', ' ') }} FCFA</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Commandes en cours --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">En cours</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $stats['commandes_en_cours'] ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Graphiques --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Répartition des commandes</h5>
                    <canvas id="commandesChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Alertes --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Alertes</h5>
                    <div class="activity">
                        @forelse($alertes ?? [] as $alerte)
                        <div class="activity-item d-flex">
                            <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
                            <div class="activity-content">
                                {{ $alerte }}
                            </div>
                        </div>
                        @empty
                        <p>Aucune alerte</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endrole

@role('personnel')
<section class="section dashboard">
    <div class="row">
        {{-- Info Pressing --}}
        <div class="col-12">
            <div class="alert alert-info">
                <h4>{{ auth()->user()->personnel->pressing->nom }}</h4>
                <p>{{ auth()->user()->personnel->pressing->adresse }}</p>
            </div>
        </div>

        {{-- Commandes du jour --}}
        <div class="col-12">
            <div class="card recent-sales">
                <div class="card-body">
                    <h5 class="card-title">Commandes à traiter aujourd'hui</h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>État</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandes_jour ?? [] as $commande)
                            <tr>
                                <td>#{{ $commande->commande_id }}</td>
                                <td>{{ $commande->client->user->name }}</td>
                                <td>{{ $commande->typePrestation->intitule }}</td>
                                <td>
                                    <span class="badge bg-{{ $commande->etat == 'En_attente' ? 'warning' : 'success' }}">
                                        {{ $commande->etat }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('commandes.show', $commande->commande_id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucune commande à traiter</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endrole

@endsection
