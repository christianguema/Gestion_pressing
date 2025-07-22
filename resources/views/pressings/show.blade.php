{{-- @extends('layouts.base')

@section('content')
    <div class="container">
        <h1>Détails du Pressing : {{ $pressing->nom }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informations générales</h5>
                <p><strong>Nom :</strong> {{ $pressing->nom }}</p>
                <p><strong>Adresse :</strong> {{ $pressing->adresse ?? 'Non renseignée' }}</p>
            </div>
        </div>

        <!-- Section Personnels -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Personnels</h5>
            </div>
            <div class="card-body">
                @if($pressing->personnels->isNotEmpty())
                    <ul>
                        @foreach($pressing->personnels as $personnel)
                            <li>{{ $personnel->nom }} - {{ $personnel->role }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun personnel enregistré.</p>
                @endif
            </div>
        </div>

        <!-- Section Commandes -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Commandes</h5>
            </div>
            <div class="card-body">
                @if($pressing->commandes->isNotEmpty())
                    <ul>
                        @foreach($pressing->commandes as $commande)
                            <li>
                                {{ $commande->client->nom ?? 'Client inconnu' }} - {{ $commande->etat }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucune commande enregistrée.</p>
                @endif
            </div>
        </div>

        <!-- Section Rapport de performance -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Rapport de performance</h5>
            </div>
            <div class="card-body">
                @if($pressing->rapportPerformance->isNotEmpty())
                    <ul>
                        @foreach($pressing->rapportPerformance as $rapport)
                            <li>Date : {{ $rapport->date_rapport }} - {{ $rapport->description }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun rapport de performance enregistré.</p>
                @endif
            </div>
        </div>

        <a href="{{ route('pressings.index') }}" class="btn btn-secondary">Retour à la liste</a>
        <a href="{{ route('pressings.edit', $pressing->pressing_id) }}" class="btn btn-warning">Modifier</a>
    </div>
@endsection --}}

@extends('layouts.base')
@section('title','Détails sur les pressings')

@section('content')
    <div class="container">
        <h1>Détails du Pressing : {{ $pressing->nom }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informations générales</h5>
                <p><strong>Nom :</strong> {{ $pressing->nom }}</p>
                <p><strong>Adresse :</strong> {{ $pressing->adresse ?? 'Non renseignée' }}</p>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Nombre de personnels</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pressing->personnels_count }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Nombre de commandes</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pressing->commandes_count }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Nombre de rapports</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pressing->rapport_performance_count }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <a href="{{ route('pressings.index') }}" class="btn btn-secondary">Retour à la liste</a>
        <a href="{{ route('pressings.edit', $pressing->pressing_id) }}" class="btn btn-warning">Modifier</a>
    </div>
    
@endsection