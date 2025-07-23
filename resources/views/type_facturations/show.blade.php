@extends('layouts.base')
@section('title', 'Détails du Type de Facturation')

@section('content')
    <div class="container">
        <h1>Détails du Type de Facturation</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Libellé : {{ $typeFacturation->libelle }}</h5>
                <p class="text-muted">
                    Créé le : {{ $typeFacturation->created_at->format('d/m/Y à H:i') }}<br>
                    Dernière modification : {{ $typeFacturation->updated_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('type_facturations.edit', $typeFacturation) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('type_facturations.index') }}" class="btn btn-secondary">Retour à la liste</a>

            <!-- Optionnel : Suppression -->
            <form action="{{ route('type_facturations.destroy', $typeFacturation) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de facturation ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
@endsection