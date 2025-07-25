@extends('layouts.base')
@section('title','Type Facturation')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>GESTION DES TYPES PRESTATATIONS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('type_prestations.index') }}">Type prestation</a></li>
            <li class="breadcrumb-item active">Listes</li>
        </ol>
    </nav>
</div>

<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('type_prestations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un Type de prestation
    </a>
</div>

<div class="clearfix row g-3">
    <div class="col-sm-12">
        <div class="mb-3 card">
            <div class="card-body">
                <table class="table mb-0 align-middle table-striped datatable">
                    <thead>
                        <tr>
                            <th scope="col">Libellé</th>
                            <th scope="col">Durée moyenne</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($typePrestations as $typePrestation)
                            <tr>
                                <td>{{ $typePrestation->intitule }}</td>
                                <td>{{ $typePrestation->duree_moyenne }}</td>
                                <td>
                                    <button class="btn edit-btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modifyfacturation" data-intitulle="{{ $typePrestation->intitule }}" data-duree="{{ $typePrestation->duree_moyenne }}"
                                        data-id="{{ $typePrestation->type_prestation_id }}">
                                        <i class="bi bi-pencil"></i>Modifier
                                    </button>
                                    <button type="button" data-id="{{ $typePrestation->type_prestation_id }}"
                                        class="btn delete-btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deletetypeprestation">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Aucune prestation enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@include('components.modals.type_prestation.deleteConfirm')
@include('components.modals.type_prestation.edit')

@endsection
