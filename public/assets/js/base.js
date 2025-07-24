//code pour la confirmation de la suppression d'un compte personnel
$(document).on('click', '.delete-btn', function () {
  var id = $(this).data("id");
  $('#deletePersonnelForm').attr('action', '/gestionnaire/personnel/' + id);
});



// Remplissage du modal personnel
$(document).on('click', '.view-btn', function () {
    $('#personnel-image').attr('src', $(this).data('image'));
    $('#personnel-nom').text(($(this).data('nom')) + ' ' + ($(this).data('prenom')));
    $('#personnel-poste').text($(this).data('poste'));
    $('#personnel-email').text($(this).data('email'));
    $('#personnel-contact').text($(this).data('contact'));
    $('#personnel-pressing').text($(this).data('pressing'));
    $('#personnel-birthday').text($(this).data('datenaissance'));
});



//let vetements = @json($vetements);

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

var successModal = new bootstrap.Modal(document.getElementById('successModal'));
successModal.show();

var errorModal = new bootstrap.Moda(document.getElementById('errorModal'));
errorModal.show();
