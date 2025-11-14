@extends('layouts.base')

@section('title', "Rapport - {$pressing->nom}-{$pressing->adresse}")

@section('content')
<div class="container">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2>{{ $title }}</h2>
        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">← Retour aux rapports</a>
    </div>

    <!-- Filtres -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="journalier" {{ $type=='journalier' ? 'selected' : '' }}>Journalier</option>
                    <option value="hebdomadaire" {{ $type=='hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="mensuel" {{ $type=='mensuel' ? 'selected' : '' }}>Mensuel</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ $date->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('rapports.export.pdf') }}?pressing_id={{ $pressing->pressing_id }}&type={{ $type }}&date={{ $date->format('Y-m-d') }}"
                    class="btn btn-danger">
                    📄 Exporter en PDF
                </a>
            </div>
        </div>
    </form>

    <!-- Graphique -->
    <canvas id="rapportChart" height="100"></canvas>

    <!-- Tableau -->
    <div class="mt-4 table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Nombre de Commandes</th>
                    <th>Revenus (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rapports as $rapport)
                <tr>
                    <td>{{ $rapport->periode->format('d/m/Y') }}</td>
                    <td>{{ $rapport->nombre_commande }}</td>
                    <td>{{ number_format($rapport->revenus, 0, ',', ' ') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Aucun rapport disponible pour cette période.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rapportChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Revenus (FCFA)',
                    data: @json($revenus),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Nombre de Commandes',
                    data: @json($commandes),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Évolution des performances' }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
