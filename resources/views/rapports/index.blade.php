@extends('layouts.base')

@section('title', 'Rapports de Performance')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    {{-- Formulaire de filtres --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="pressing_id" class="form-label">Pressing</label>
                                <select name="pressing_id" id="pressing_id" class="form-control">
                                    <option value="">Tous les pressings</option>
                                    @foreach($pressings as $pressing)
                                        <option value="{{ $pressing->pressing_id }}"
                                                {{ $pressingId == $pressing->pressing_id ? 'selected' : '' }}>
                                            {{ $pressing->nom }} - {{ $pressing->adresse }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="type" class="form-label">Type de rapport</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="journalier" {{ $type == 'journalier' ? 'selected' : '' }}>Journalier</option>
                                    <option value="hebdomadaire" {{ $type == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                                    <option value="mensuel" {{ $type == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="gap-2 d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filtrer
                                    </button>
                                    <a href="{{ route('rapports.export.pdf') . '?' . http_build_query(request()->all()) }}"
                                       class="btn btn-secondary">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Bouton de génération manuelle --}}
                    <div class="mb-3">
                        <a href="{{ route('rapports.generer.form') }}" class="btn btn-warning">
                            <i class="fas fa-cogs"></i> Générer Manuellement
                        </a>
                    </div>

                    {{-- Messages d'alerte --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Graphique --}}
                    @if(!empty($revenus) && array_sum($revenus) > 0)
                        <div class="mb-4 card">
                            <div class="card-body">
                                <h5 class="card-title">Graphique des performances</h5>
                                <canvas id="rapportChart" height="100"></canvas>
                            </div>
                        </div>
                    @endif

                    {{-- Résumé statistique --}}
                    @if($rapports->isNotEmpty())
                        <div class="mb-4 row">
                            <div class="col-md-3">
                                <div class="text-center text-white card bg-primary">
                                    <div class="card-body">
                                        <h5>{{ $rapports->count() }}</h5>
                                        <p class="mb-0">Périodes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center text-white card bg-success">
                                    <div class="card-body">
                                        <h5>{{ number_format($rapports->sum('nombre_commande'), 0, ',', ' ') }}</h5>
                                        <p class="mb-0">Total Commandes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center text-white card bg-warning">
                                    <div class="card-body">
                                        <h5>{{ number_format($rapports->sum('revenus'), 0, ',', ' ') }} FCFA</h5>
                                        <p class="mb-0">Total Revenus</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center text-white card bg-info">
                                    <div class="card-body">
                                        <h5>{{ $rapports->count() > 0 ? number_format($rapports->sum('revenus') / $rapports->count(), 0, ',', ' ') : 0 }} FCFA</h5>
                                        <p class="mb-0">Moyenne/Période</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tableau des données --}}
                    @if($rapports->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Pressing</th>
                                        <th>Nb Commandes</th>
                                        <th>Revenus (FCFA)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rapports as $rapport)
                                        <tr>
                                            <td>
                                                <strong>{{ \Carbon\Carbon::parse($rapport->periode)->format('d/m/Y') }}</strong>
                                                <br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($rapport->periode)->format('l') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $rapport->pressing->nom }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $rapport->pressing->adresse }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6">{{ $rapport->nombre_commande }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($rapport->revenus, 0, ',', ' ') }}</strong>
                                            </td>
                                            <td>
                                                <a href="{{ route('rapports.par.pressing', $rapport->pressing) }}?type={{ $type }}&date={{ $rapport->periode }}"
                                                   class="btn btn-sm btn-outline-primary" title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center alert alert-info">
                            <i class="mb-3 fas fa-info-circle fa-3x"></i>
                            <h5>Aucune donnée disponible</h5>
                            <p>Aucun rapport n'a été trouvé pour les critères sélectionnés.</p>
                            <a href="{{ route('rapports.generer.form') }}" class="btn btn-warning">
                                <i class="fas fa-plus"></i> Générer des rapports
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script pour le graphique --}}
@if(!empty($revenus) && array_sum($revenus) > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('rapportChart').getContext('2d');

            const revenus = @json($revenus);
            const commandes = @json($commandes);
            const labels = @json($labels);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Revenus (FCFA)',
                            data: revenus,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Nombre de Commandes',
                            data: commandes,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Période'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Revenus (FCFA)'
                            },
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Nombre de Commandes'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Performance des Revenus et Commandes'
                        },
                        legend: {
                            display: true
                        }
                    }
                }
            });
        });
    </script>
@endif
@endsection
