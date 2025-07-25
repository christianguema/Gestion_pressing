@extends('layouts.base')

@section('title', 'Ajouter un Type de Facturation')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif


<div class="pagetitle">
    <h1>AJOUTER UN TYPE DE PRESTATION</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('type_prestations.index') }}">Type de Prestation</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>
</div>

<div class="container">
    <form action="{{ route('type_prestations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="intitule" class="form-label">Intitulé</label>
            <input type="text" class="form-control @error('intitule') is-invalid @enderror" id="intitule"
                name="intitule" value="{{ old('intitule') }}" required>
            @error('intitule')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="duree_moyenne" class="form-label">Durée moyenne (jours)</label>
            <input type="number" class="form-control @error('duree_moyenne') is-invalid @enderror" id="duree_moyenne"
                name="duree_moyenne" value="{{ old('duree_moyenne') }}" min="0" step="1">
            <small class="text-muted">Exemple : 2 jours pour un nettoyage classique.</small>
            @error('duree_moyenne')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('type_prestations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
