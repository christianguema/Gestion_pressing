@extends('layouts.base')

@section('title','Liste des pressings')

@section('content')

@if(session('success'))
    @include('components.alertModals.success')
@endif

@if(session('error'))
    @include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES PRESSINGS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pressings.index') }}">Pressings</a></li>
            <li class="breadcrumb-item active">Listes</li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('pressings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un personnel
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pressings as $pressing)
        <tr>
            <td>{{ $pressing->nom }}</td>
            <td>{{ $pressing->adresse }}</td>
            <td>
                <button class="btn show-btn btn-info btn-sm">
                    <a href="{{ route('pressings.show', $pressing->pressing_id) }}">
                        <i class="bi bi-eye"></i>Voir
                    </a>
                </button>
                <button class="btn edit-btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modifypressing"
                    data-libelle="{{ $pressing->nom }}" data-adress="{{ $pressing->adresse }}"
                    data-id="{{ $pressing->pressing_id }}">
                    <i class="bi bi-pencil"></i>Modifier
                </button>
                <button type="button" data-id="{{ $pressing->pressing_id }}" class="btn delete-btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#deletepressing">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('components.modals.pressing.edit')
@include('components.modals.pressing.delete')
@endsection
