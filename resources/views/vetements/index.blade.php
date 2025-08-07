@extends('layouts.base')

@section('title', 'Liste des Vêtements')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES VÊTEMENTS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vetements.index') }}">Vêtements</a></li>
            <li class="breadcrumb-item active">Listes</li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('vetements.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un vêtement
    </a>
    <div>
        <button class="mt-1 btn btn-primary dropdown-toggle w-sm-100" type="button" id="dropdownMenuButton2"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i> Filtrer par catégorie
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
            <li>
                <a class="dropdown-item {{ empty(request('categorie_id')) ? 'active' : '' }}"
                    href="{{ route('vetements.index') }}">
                    Toutes les catégories
                </a>
            </li>
            @foreach($categories as $cat)
            <li>
                <a class="dropdown-item {{ request('categorie_id') == $cat->categorie_id ? 'active' : '' }}"
                    href="{{ route('vetements.index', ['categorie_id' => $cat->categorie_id]) }}">
                    {{ $cat->intitule }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- <form method="GET" action="{{ route('vetements.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Rechercher un vêtement..."
            value="{{ request('search') }}" oninput="this.form.submit()">
        <button type="submit" class="btn btn-outline-secondary">Rechercher</button>
        @if(request()->has('search'))
        <a href="{{ route('vetements.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        @endif
    </div>
</form> --}}

@if($vetements->isEmpty())
<p>Aucun vêtement trouvé.</p>
@else
<table class="table table-striped datatable">
    <thead>
        <tr>
            <th>Numero</th>
            <th>Designation</th>
            <th>Prix Unitaire</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vetements as $vetement)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{ $vetement->type }}</td>
            <td>{{ $vetement->prix_unitaire ?? 'Non défini' }}</td>
            <td>{{ $vetement->categorie->intitule }}</td>
            <td>
                <a href="{{ route('vetements.show', $vetement) }}" class="btn btn-sm btn-info"><i
                        class="bi bi-eye"></i>Voir</a>
                <a href="{{ route('vetements.edit', $vetement) }}" class="btn btn-sm btn-warning"><i
                        class="bi-pencil"></i> Modifier</a>
                <button type="button" data-id="{{ $vetement->vetement_id }}" class="btn delete-btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#deleteVetement">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@include('components.modals.vetement.delete')
@endsection
