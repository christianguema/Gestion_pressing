@extends('layouts.base')

@section('title', 'Détails du Vêtement')

@section('content')
    <div class="pagetitle">
        <h1>DÉTAILS DU VÊTEMENT</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vetements.index') }}">Vêtements</a></li>
                <li class="breadcrumb-item active">Détails</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Vêtement : {{ $vetement->type }}</h5>

            <table class="table table-borderless">
                <tr>
                    <th>Type</th>
                    <td>{{ $vetement->type }}</td>
                </tr>
                <tr>
                    <th>Prix unitaire</th>
                    <td>{{ $vetement->prix_unitaire ? number_format($vetement->prix_unitaire, 2, ',', ' ') ." ".'FrCFA' : 'Non défini' }}</td>
                </tr>
                <tr>
                    <th>Catégorie</th>
                    <td>{{ $vetement->categorie->intitule }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('vetements.edit', $vetement) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('vetements.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
@endsection
