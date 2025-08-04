{{-- filepath: resources/views/commandes/create.blade.php --}}
@extends('layouts.base')

@section('title', 'Enregistrement Commande')

@section('content')

<div class="pagetitle">
    <h1>ENREGISTREMENT COMMANDE</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('commandes.pendingIndex') }}">Commandes</a></li>
            <li class="breadcrumb-item active">Enregistrement</li>
        </ol>
    </nav>
</div>

<section>
    <form id="commandeForm" method="POST" action="{{ route('commandes.store') }}">
        @csrf
        <!-- Step 1 : Client -->
        <div class="mb-4 card step-form" id="step1">
            <div class="card-header">Client</div>
            <div class="card-body row g-3">
                <div class="col-md-12">
                    <label class="form-label">Rechercher un client par nom</label>
                    <div class="input-group">
                        <input type="text" id="client_search" class="form-control" autocomplete="off"
                            placeholder="Nom du client">
                        <button type="button" id="showNewClientBtn" class="btn btn-outline-primary"
                            style="display:none;">Créer le client</button>
                    </div>
                    <div id="clientSuggestions" class="mt-1 list-group"></div>
                    <input type="hidden" name="client_id" id="client_id">
                </div>
                <div id="newClientFields" style="display:none;">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="client_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Prénom</label>
                        <input type="text" name="last_name" id="client_last_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="client_contact" class="form-label">Contact</label>
                        <input type="text" name="contact" id="client_contact" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="client_email" class="form-label">Email</label>
                        <input type="email" name="email" id="client_email" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="button" class="btn btn-primary next-step">Suivant</button>
            </div>
        </div>

        <!-- Step 2 : Informations générales -->
        <div class="mb-4 card step-form" id="step2" style="display:none;">
            <div class="card-header">Informations générales</div>
            <div class="card-body row g-3">
                <div hidden>
                    <input type="text" value="{{ Auth::user()->personnel->pressing->pressing_id }}" name="pressing_id"
                        id="pressing_id">
                    <input type="text" value="{{ Auth::user()->personnel->personnel_id }}" name="personnel_id"
                        id="personnel_id">
                </div>
                <div class="form-group">
                    <label>Remise (optionnel)</label>
                    <select name="remise_id" class="form-control">
                        <option value="">Aucune remise</option>
                        @foreach($remises as $remise)
                        <option value="{{ $remise->remise_id }}">{{ $remise->description }} ({{ $remise->type ==
                            'pourcentage' ? $remise->valeur.'%' : $remise->valeur.' FCFA' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="type_facturation_id" class="form-label">Type de facturation</label>
                    <select name="type_facturation_id" id="type_facturation_id" class="form-select" required>
                        <option selected disabled>Sélectionner</option>
                        @foreach($typeFacturations as $facturation)
                        <option value="{{ $facturation->type_facturation_id }}">{{ $facturation->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="type_prestation_id" class="form-label">Type de prestation</label>
                    <select name="type_prestation_id" id="type_prestation_id" class="form-select" required>
                        <option selected disabled>Sélectionner</option>
                        @foreach($typePrestations as $prestation)
                        <option value="{{ $prestation->type_prestation_id }}">{{ $prestation->intitule }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="date_reception" class="form-label">Date de réception</label>
                    <input type="date" name="date_reception" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                        readonly id="date_reception" class="form-control" required>
                </div>
                <div class="col-md-6" id="dateLivraisonField" style="display:none;">
                    <label for="date_livraison" class="form-label">Date de livraison (Express)</label>
                    <input type="date" name="date_livraison" min="{{ date('Y-m-d') }}" id="date_livraison"
                        class="form-control">
                </div>
                <div class="col-md-6" id="poidsTotalField" style="display:none;">
                    <label for="poids_total" class="form-label">Poids total (kg)</label>
                    <input type="number" step="1" min="0" name="poids_total" id="poids_total" class="form-control">
                </div>
                <div class="col-md-6" id="prixUnitaireKiloField" style="display:none;">
                    <label for="prix_unitaire_kilo" class="form-label">Prix unitaire par kilo</label>
                    <input type="number" step="100" min="0" name="prix_unitaire_kilo" id="prix_unitaire_kilo"
                        class="form-control">
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                <button type="button" class="btn btn-primary next-step" id="nextToStep3">Suivant</button>
                <button type="submit" class="btn btn-success" id="submitKilo" style="display:none;">Enregistrer la
                    commande</button>
            </div>
        </div>

        <!-- Step 3 : Vêtements -->
        <div class="mb-4 card step-form" id="step3" style="display:none;">
            <div class="card-header">Vêtements</div>
            <div class="card-body">
                <table class="table" id="vetementsTable">
                    <thead>
                        <tr>
                            <th>Nom du vêtement</th>
                            <th>Quantité</th>
                            <th>Description</th>
                            <th id="prixUnitaireTh" style="display:none;">Prix unitaire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les lignes seront ajoutées dynamiquement en JS -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary" id="addVetementRow">
                    <i class="bi bi-plus-lg"></i> Ajouter un vêtement
                </button>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                <button type="submit" class="btn btn-success">Enregistrer la commande</button>
            </div>
        </div>
    </form>
</section>

<script>
    let vetements = @json($vetements);
let clients = @json($clients);
let typePrestations = @json($typePrestations);
</script>
@endsection
