@extends('layouts.base')

@section('title', 'Liste des Personnels')

@section('content')
@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES PERSONNELS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('personnels.index') }}">Personnel</a></li>
            <li class="breadcrumb-item active">Listes</li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('personnels.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un personnel
    </a>
    <div>
        <button class="mt-1 btn btn-primary dropdown-toggle w-sm-100" type="button" id="dropdownMenuButton2"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i> Filtrer par pressing
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
            <li>
                <a class="dropdown-item {{ empty($pressingId) ? 'active' : '' }}"
                    href="{{ route('personnels.index') }}">
                    Tous
                </a>
            </li>
            @foreach($pressings as $pressing)
            <li>
                <a class="dropdown-item {{ (isset($pressingId) && $pressingId == $pressing->id) ? 'active' : '' }}"
                    href="{{ route('personnels.index', ['pressing_id' => $pressing->pressing_id]) }}">
                    {{ $pressing->nom }}--{{ $pressing->adresse }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<table class="table table-striped datatable">
    <thead>
        <tr>
            <th scope="col">Personnel</th>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Contact</th>
            <th scope="col">Poste</th>
            <th scope="col">Pressing Assigné</th>
            <th scope="col">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($personnels as $personnel)
        <tr>
            <td><strong>{{ $loop->iteration }}</strong></td>
            <td scope="row">{{ $personnel->user->name }}</td>
            <td>{{ $personnel->user->last_name }}</td>
            <td>{{ $personnel->user->contact }}</td>
            <td>{{ $personnel->poste }}</td>
            <td>{{ $personnel->pressing?->nom }}--{{ $personnel->pressing?->adresse }}</td>
            <td>
                <button class="btn view-btn btn-info btn-sm" data-nom="{{ $personnel->user->name }}"
                    data-prenom="{{ $personnel->user->last_name }}" data-contact="{{ $personnel->user->contact }}"
                    data-image="{{ asset('assets/img/profile-img.jpg') }}" data-email="{{ $personnel->user->email }}"
                    data-poste="{{ $personnel->poste }}" data-datenaissance="{{ $personnel->user->birthday }}"
                    data-pressing="{{ $personnel->pressing?->nom ?? 'Non assigné' }}" data-bs-toggle="modal"
                    data-bs-target="#viewPersonnelModal">
                    <i class="bi bi-eye"></i> Voir
                </button>

                <button type="button" data-id="{{ $personnel->personnel_id }}" class="btn delete-btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#deletePersonnel">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Aucun personnel enregistré.</td>
        </tr>
        @endforelse

    </tbody>
</table>

@include('components.confirmationModal.deleteAccount')
@include('components.modals.personnel.showPersonnel')

@endsection
