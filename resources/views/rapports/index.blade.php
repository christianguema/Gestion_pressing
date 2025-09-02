@extends('layouts.base')

@section('title', 'Rapports de Performance')

@section('content')
<div class="container">
    <h2>{{ $title }}</h2>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="pressing_id" class="form-control">
                    <option value="">Tous les pressings</option>
                    @foreach($pressings as $pressing)
                        <option value="{{ $pressing->pressing_id }}" {{ $pressingId == $pressing->pressing_id ? 'selected' : '' }}>
                            {{ $pressing->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="journalier" {{ $type == 'journalier' ? 'selected' : '' }}>Journalier</option>
                    <option value="hebdomadaire" {{ $type == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="mensuel" {{ $type == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ $date->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="{{ route('rapports.export.pdf') . '?' . http_build_query(request()->all()) }}" class="btn btn-secondary">PDF</a>
            </div>
        </div>
    </form>

    <a href="{{ route('rapports.generer.form') }}" class="mb-3 btn btn-warning">Générer Manuellement</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <canvas id="rapportChart" height="100"></canvas>

    <table class="table mt-3 table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Pressing</th>
                <th>Commandes</th>
                <th>Revenus (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rapports as $rapport)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rapport->periode)->format('d/m/Y') }}</td>
                    <td>{{ $rapport->pressing->nom }} , {{ $rapport->pressing->adresse }}</td>
                    <td>{{ $rapport->nombre_commande }}</td>
                    <td>{{ number_format($rapport->revenus, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let revenus = @json($revenus);
    let commandes = @json($commandes);
    let labels = @json($labels)
</script>
@endsection
