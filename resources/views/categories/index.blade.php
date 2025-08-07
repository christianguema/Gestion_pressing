@extends('layouts.base')

@section('title', 'Liste des Catégories')

@section('content')

@if(session('success'))
    @include('components.alertModals.success')
@endif

@if(session('error'))
    @include('components.alertModals.error')
@endif


<div class="pagetitle">
    <h1>LES CATEGORIES DE VETEMENT</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
            <li class="breadcrumb-item active">Créer</li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter une categorie
    </a>
</div>


@if($categories->isEmpty())
<p>Aucune catégorie enregistrée.</p>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Numero</th>
            <th>Intitulé</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $categorie)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{ $categorie->intitule }}</td>
            <td>
                {{-- <a href="{{ route('categories.show', $categorie) }}" class="btn btn-sm btn-info"><i
                        class="bi bi-eye"></i> Voir</a> --}}
                <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Modifier</a>
                <button type="button" data-id="{{ $categorie->categorie_id }}" class="btn delete-btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategorie">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif
@include('components.modals.categorie.delete')
@endsection
