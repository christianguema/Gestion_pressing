@extends('layouts.base')

@section('title','Mode de paiement')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES MODES DE PAIEMENTS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Mode paiement</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Modes de paiement disponibles</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </button>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @forelse($mode_paiements as $mode)
                        <div class="col">
                            <div class="card h-100">
                                <div class="pt-3 text-center card-img-top">
                                    <img src="{{ asset('storage/'.$mode->logo) }}"
                                         alt="{{ $mode->nom }}"
                                         style="height: 100px; width: auto; object-fit: contain;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $mode->nom }}</h5>
                                    @if($mode->telephone)
                                        <p class="card-text">
                                            <i class="bi bi-phone"></i> {{ $mode->telephone }}
                                        </p>
                                    @endif
                                </div>
                                <div class="bg-transparent card-footer border-top-0">
                                    <div class="btn-group w-100">
                                        <button type="button"
                                                class="btn edit-btn btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-id="{{ $mode->mode_paiement_id }}"
                                                data-nom="{{ $mode->nom }}"
                                                data-contact="{{ $mode->telephone }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button"
                                                class="btn delete-btn btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="{{ $mode->mode_paiement_id }}"
                                                data-nom="{{ $mode->nom }}"
                                                data-contact="{{ $mode->telephone }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Aucun mode de paiement disponible
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modals Edition et Suppression --}}
@include("components.modals.mode_paiements.create")
@include("components.modals.mode_paiements.edit")
@include("components.modals.mode_paiements.delete")



@endsection
