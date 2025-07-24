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
                    <label class="form-label">Sélectionner un client existant</label>
                    <select name="client_id" id="client_id" class="mb-2 form-select">
                        <option value="">-- Aucun, créer un nouveau client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->client_id }}">{{ $client->user->name }} {{ $client->user->last_name }}</option>
                        @endforeach
                    </select>
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
                @role('personnel')
                    <div hidden>
                        <input type="text" value="{{ Auth::user()->personnel->pressing->pressing_id }}" name="pressing_id" id="pressing_id">
                        <input type="text" value="{{ Auth::user()->personnel->personnel_id }}" name="personnel_id" id="">
                    </div>
                @endrole
                @role('gestionnaire')
                    <div class="col-md-6">
                        <label for="pressing_id" class="form-label">Pressing</label>
                        <select name="pressing_id" id="pressing_id" class="form-select" required>
                            <option value="">Sélectionner un pressing</option>
                            @foreach($pressings as $pressing)
                                <option value="{{ $pressing->pressing_id }}">{{ $pressing->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                @endrole
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
                    <input type="date" name="date_reception" min="{{ date('Y-m-d') }}" id="date_reception" class="form-control" required>
                </div>
                <div class="col-md-6" id="dateLivraisonField" style="display:none;">
                    <label for="date_livraison" class="form-label">Date de livraison (Express)</label>
                    <input type="date" name="date_livraison" min="{{ date('Y-m-d') }}" id="date_livraison" class="form-control">
                </div>
                <!-- Champ poids total (visible uniquement si facturation par kilo) -->
                <div class="col-md-6" id="poidsTotalField" style="display:none;">
                    <label for="poids_total" class="form-label">Poids total (kg)</label>
                    <input type="number" step="1" min="0" name="poids_total" id="poids_total" class="form-control">
                </div>
                <div class="col-md-6" id="prixUnitaireKiloField" style="display:none;">
                    <label for="prix_unitaire_kilo" class="form-label">Prix unitaire par kilo</label>
                    <input type="number" step="500" min="0" name="prix_unitaire_kilo" id="prix_unitaire_kilo" class="form-control">
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                <button type="button" class="btn btn-primary next-step" id="nextToStep3">Suivant</button>
                <button type="submit" class="btn btn-success" id="submitKilo" style="display:none;">Enregistrer la commande</button>
            </div>
        </div>

        <!-- Step 3 : Vêtements -->
        <div class="mb-4 card step-form" id="step3" style="display:none;">
            <div class="card-header">Vêtements</div>
            <input type="text" value="{{ $vetements }}" id="vetements" hidden>
            <div class="card-body">
                <table class="table" id="vetementsTable">
                    <thead>
                        <tr>
                            <th>Nom du vêtement</th>
                            <th>Quantité</th>
                            <th>Couleur</th>
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

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    let vetements = @json($vetements);
</script>

{{-- <script>
    let vetements = @json($vetements);

    // Affichage dynamique selon le type de facturation
    $('#type_facturation_id').on('change', function() {
        let selected = $(this).find('option:selected').text().toLowerCase();
        if (selected.includes('kilo') || selected.includes('poids')) {
            $('#poidsTotalField').show();
            $('#prixUnitaireKiloField').show();
            $('#poids_total, #prix_unitaire_kilo').prop('required', true);
            $('#step3').hide();
            $('#nextToStep3').hide();
            $('#submitKilo').show();
        } else {
            $('#poidsTotalField').hide();
            $('#prixUnitaireKiloField').hide();
            $('#poids_total, #prix_unitaire_kilo').prop('required', false).val('');
            $('#step3').show();
            $('#nextToStep3').show();
            $('#submitKilo').hide();
        }

        // Affiche ou cache le champ prix unitaire dans la table vêtements
        if (selected.includes('vetement')) {
            $('#prixUnitaireTh').show();
            $('#vetementsTable tbody tr').each(function() {
                $(this).find('.prix-unitaire-td').show();
                $(this).find('.prix-unitaire-input').prop('required', true);
            });
        } else {
            $('#prixUnitaireTh').hide();
            $('#vetementsTable tbody tr').each(function() {
                $(this).find('.prix-unitaire-td').hide();
                $(this).find('.prix-unitaire-input').prop('required', false).val('');
            });
        }
    });

    // Multi-step navigation
    $(document).on('click', '.next-step', function() {
        let $current = $(this).closest('.step-form');
        let $next = $current.next('.step-form');
        $current.hide();
        $next.show();
    });
    $(document).on('click', '.prev-step', function() {
        let $current = $(this).closest('.step-form');
        let $prev = $current.prev('.step-form');
        $current.hide();
        $prev.show();
    });


    // Client: afficher les champs de création si aucun client sélectionné
    $('#client_id').on('change', function() {
        if (!$(this).val()) {
            $('#newClientFields').show();
            $('#newClientFields input').prop('required', true);
        } else {
            $('#newClientFields').hide();
            $('#newClientFields input').prop('required', false);
        }
    });

    // Date livraison affichée seulement pour prestation express
    $('#type_prestation_id').on('change', function() {
        let selected = $(this).find('option:selected').text().toLowerCase();
        if (selected.includes('express')) {
            $('#dateLivraisonField').show();
            $('#date_livraison').prop('required', true);
        } else {
            $('#dateLivraisonField').hide();
            $('#date_livraison').prop('required', false).val('');
        }
    });

    // Affichage du champ poids total uniquement pour facturation par poids
    $('#type_facturation_id').on('change', function() {
        let selected = $(this).find('option:selected').text().toLowerCase();
        if (selected.includes('kilo') || selected.includes('poids')) {
            $('#poidsTotalField').show();
            $('#poids_total').prop('required', true);
        } else {
            $('#poidsTotalField').hide();
            $('#poids_total').prop('required', false).val('');
        }
    });

    // Ajout/suppression de ligne vêtement
    function createVetementRow() {
        return `<tr>
            <td>
                <input type="text" class="form-control vetement-search" name="vetements[][type]" autocomplete="off" placeholder="Nom du vêtement">
                <div class="vetement-suggestions"></div>
                <input type="hidden" name="vetements[][vetement_id]" class="vetement-id">
            </td>
            <td><input type="number" min="1" name="vetements[][quantite]" class="form-control"></td>
            <td><input type="text" name="vetements[][couleur_vetement]" class="form-control"></td>
            <td class="prix-unitaire-td" style="display:none;">
                <input type="number" step="0.01" min="0" name="vetements[][prix_unitaire]" class="form-control prix-unitaire-input">
            </td>
            <td><button type="button" class="btn btn-danger btn-sm remove-vetement-row"><i class="bi bi-trash"></i></button></td>
        </tr>`;
    }

    $('#addVetementRow').on('click', function() {
        $('#vetementsTable tbody').append(createVetementRow());
        // Affiche le champ prix unitaire si facturation par vêtement
        let selected = $('#type_facturation_id').find('option:selected').text().toLowerCase();
        if (selected.includes('vetement')) {
            $('#vetementsTable tbody tr:last .prix-unitaire-td').show();
            $('#vetementsTable tbody tr:last .prix-unitaire-input').prop('required', true);
        }
    });
    $(document).on('click', '.remove-vetement-row', function() {
        $(this).closest('tr').remove();
    });

    // Recherche assistée vêtements
    function getVetementOptions(search = '') {
        if (!search) return vetements;
        return vetements.filter(v => v.type.toLowerCase().includes(search.toLowerCase()));
    }

    $(document).on('input', '.vetement-search', function() {
        let $input = $(this);
        let search = $input.val();
        let options = getVetementOptions(search);
        let $suggestions = $input.siblings('.vetement-suggestions');
        $suggestions.empty();
        if (search && options.length) {
            options.forEach(v => {
                $suggestions.append(`<div class="suggestion-item" data-id="${v.vetement_id}" data-type="${v.type}">${v.type}</div>`);
            });
            $suggestions.show();
        } else {
            $suggestions.hide();
        }
    });
    $(document).on('click', '.suggestion-item', function() {
        let $item = $(this);
        let $input = $item.closest('td').find('.vetement-search');
        $input.val($item.data('type'));
        $input.siblings('.vetement-id').val($item.data('id'));
        $input.siblings('.vetement-suggestions').hide();
    });
    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('vetement-search')) {
            $('.vetement-suggestions').hide();
        }
    });
</script> --}}
@endsection
