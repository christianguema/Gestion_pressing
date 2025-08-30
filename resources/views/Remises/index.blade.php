@extends('layouts.base')

@section('title','Remise')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES REMISES</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('remises.index') }}">Remises</a></li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <button class="btn add-btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRemise">
        <i class="bi bi-plus-lg"></i>Ajouter une remise
    </button>
</div>


<table class="table table-striped datatable">
    <thead>
        <tr>
            <th scope="col">Numero</th>
            <th scope="col">Type de remise</th>
            <th scope="col">Valeur</th>
            <th scope="col">Description</th>
            <th scope="col">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($remises as $remise)
        <tr>
            <td><strong>{{ $loop->iteration }}</strong></td>
            <td>{{ $remise->type_remise }}</td>
            @if($remise->type_remise == "fixe")
            <td>{{ $remise->valeur }} FCFA</td>
            @else
            <td>{{ $remise->valeur }}%</td>
            @endif
            <td>{{ $remise->description }}</td>
            <td>
                <button type="button" data-id="{{ $remise->remise_id }}" data-valeur="{{ $remise->valeur }}"
                    data-type_remise="{{ $remise->type_remise }}" data-description="{{ $remise->description }}"
                    class="btn update-btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateRemise">
                    <i class="bi bi-pencil"></i> Modifier
                </button>

                <button type="button" data-id="{{ $remise->remise_id }}" class="btn delete-btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#deleteRemise">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Aucune remise enregistré</td>
        </tr>
        @endforelse
    </tbody>
</table>

@include('components.modals.remises.create')
@include('components.modals.remises.edit')
@include('components.modals.remises.delete')
@endsection
