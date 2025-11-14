@extends('layouts.base')
@section('title','Détails sur les pressings')

@section('content')

<div class="pagetitle">
    <h1>DETAIL DU PRESSING</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pressings.index') }}">Pressings</a></li>
            <li class="breadcrumb-item active">Listes</li>
        </ol>
    </nav>
</div>

<div class="mb-4 card">
    <div class="card-body">
        <h5 class="card-title">Informations générales</h5>
        <p><strong>Nom :</strong> {{ $pressing->nom }}</p>
        <p><strong>Adresse :</strong> {{ $pressing->adresse ?? 'Non renseignée' }}</p>
    </div>
</div>

<!-- Statistiques -->
<div class="row">
    <div class="col-md-4">
        <div class="mb-3 text-white card bg-primary">
            <div class="card-header">Nombre de personnels</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pressing->personnels_count }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3 text-white card bg-success">
            <div class="card-header">Nombre de commandes</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pressing->commandes_count }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3 text-white card bg-info">
            <div class="card-header">Nombre de rapports</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pressing->rapport_performance_count }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Boutons -->
<a href="{{ route('pressings.index') }}" class="btn btn-secondary">Retour à la liste</a>
{{-- <a href="{{ route('pressings.edit', $pressing->pressing_id) }}" class="btn btn-warning">Modifier</a> --}}

@endsection
