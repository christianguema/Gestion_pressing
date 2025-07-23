@extends('layouts.base')
@section('title', 'Détails du Type de Prestation')

@section('content')
    <div class="container">
        <h1>Détails du Type de Prestation</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Intitulé : {{ $typePrestation->intitule }}</h5>
                <p class="text-muted">
                    Créé le : {{ $typePrestation->created_at->format('d/m/Y à H:i') }}<br>
                    Dernière modification : {{ $typePrestation->updated_at->format('d/m/Y à H:i') }}
                </p>

                <p><strong>Durée moyenne :</strong>
                    {{ $typePrestation->duree_moyenne ? $typePrestation->duree_moyenne . ' jour(s)' : 'Non définie' }}
                </p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('type_prestations.edit', $typePrestation) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('type_prestations.index') }}" class="btn btn-secondary">Retour à la liste</a>

            <form action="{{ route('type_prestations.destroy', $typePrestation) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Supprimer ce type de prestation ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
@endsection