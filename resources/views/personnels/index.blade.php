{{-- @extends('layouts.base')

@section('title', 'Liste des Personnels')

@section('content')
    <div class="container">
        <h1>Liste des Personnels</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personnels as $personnel)
                    <tr>
                        <td>{{ $personnel->id }}</td>
                        <td>{{ $personnel->name }}</td>
                        <td>{{ $personnel->email }}</td>
                        <td>{{ $personnel->position }}</td>
                        <td>
                            <a href="{{ route('personnels.show', $personnel->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('personnels.edit', $personnel->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('personnels.destroy', $personnel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $personnels->links() }}
    </div>

    
@endsection --}}

<!-- resources/views/personnels/index.blade.php -->

{{-- @extends('layouts.base')

@section('title', 'Liste des Personnels')
@section('content')

    <div class="pagetitle">
        <h1>PERSONNELS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Personnels</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                Liste des personnels
                <a href="{{ route('personnels.create') }}" class="btn btn-primary float-end">Ajouter</a>
            </h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Poste</th>
                        <th>Pressing</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($personnels as $p)
                        <tr>
                            <td>{{ $p->user->name }} {{ $p->user->lastname }}</td>
                            <td>{{ $p->user->email }}</td>
                            <td>{{ $p->poste }}</td>
                            <td>{{ $p->pressing?->nom ?? 'Non assigné' }}</td>
                            <td>
                                <!-- À compléter plus tard -->
                                <button class="btn btn-sm btn-secondary" disabled>Modifier</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection --}}

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
        <button class="mt-1 btn btn-primary dropdown-toggle w-sm-100" type="button"
            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i> Filtrer par pressing
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
            <li>
                <a class="dropdown-item {{ empty($pressingId) ? 'active' : '' }}" href="{{ route('personnels.index') }}">
                    Tous
                </a>
            </li>
            @foreach($pressings as $pressing)
                <li>
                    <a class="dropdown-item {{ (isset($pressingId) && $pressingId == $pressing->id) ? 'active' : '' }}"
                        href="{{ route('personnels.index', ['pressing_id' => $pressing->pressing_id]) }}">
                        {{ $pressing->nom }}  {{$pressing->adresse }}
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
        {{-- incrémentation automatique du numéro de personnel --}}
        <th>{{$loop->iteration}}</th>
        <th scope="row">{{ $personnel->user->name }}</th>
        <td>{{ $personnel->user->lastname }}</td>
        <td>{{ $personnel->user->contact }}</td>
        <td>{{ $personnel->poste }}</td>
        <td>{{ $personnel->pressing?->nom }},{{ $personnel->pressing?->adresse }}</td>
        <td>
            <button class="btn view-btn btn-info btn-sm"
                data-nom="{{ $personnel->user->name }}"
                data-prenom="{{ $personnel->user->lastname }}"
                data-contact="{{ $personnel->user->contact }}"
                data-image="{{ asset('storage/profil_images/'.$personnel->profilImage) }}"
                data-email="{{ $personnel->user->email }}"
                data-poste="{{ $personnel->poste }}"
                data-datenaissance="{{ $personnel->user->birthday }}"
                data-pressing="{{ $personnel->pressing?->nom ?? 'Non assigné' }}"
                data-image="{{ $personnel->profilImage }}"
                data-bs-toggle="modal"
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
        <td colspan="6" class="text-center">Aucun personnel enregistré.</td>
    </tr>
    @endforelse

  </tbody>
</table>

@include('components.confirmationModal.deleteAccount')
@include('components.modals.personnel.showPersonnel')

@endsection
