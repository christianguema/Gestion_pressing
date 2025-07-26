@extends('layouts.base')

@section('title', 'Détails de la Catégorie')

@section('content')
    <div class="pagetitle">
        <h1>DÉTAILS DE LA CATÉGORIE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
                <li class="breadcrumb-item active">Détails</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Catégorie : {{ $categorie->intitule }}</h5>

            <p><strong>Nombre de vêtements :</strong>
                {{ $categorie->vetements_count ?? $categorie->vetements->count() }}
            </p>

            <h6 class="mt-4">Vêtements associés</h6>
            @if($categorie->vetements->isEmpty())
                <p>Aucun vêtement dans cette catégorie.</p>
            @else
                <ul class="list-group">
                    @foreach($categorie->vetements as $vetement)
                        <li class="list-group-item">
                            {{ $vetement->type }}
                            @if($vetement->prix_unitaire)
                                <span class="badge bg-primary float-end">
                                    {{ number_format($vetement->prix_unitaire, 2, ',', ' ') }} €
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
@endsection