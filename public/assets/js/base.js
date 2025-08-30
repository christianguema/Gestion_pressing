//code pour la confirmation de la suppression d'un compte personnel
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deletePersonnelForm").attr("action", "/gestionnaire/personnels/" + id);
});

// Remplissage du modal personnel
$(document).on("click", ".view-btn", function () {
    $("#personnel-image").attr("src", $(this).data("image"));
    $("#personnel-nom").text(
        $(this).data("nom") + " " + $(this).data("prenom")
    );
    $("#personnel-poste").text($(this).data("poste"));
    $("#personnel-poste2").text($(this).data("poste"));
    $("#personnel-email").text($(this).data("email"));
    $("#personnel-contact").text($(this).data("contact"));
    $("#personnel-pressing").text($(this).data("pressing"));
    $("#personnel-birthday").text($(this).data("datenaissance"));
});

//gestion des modales de mode_paiement
//suppression
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deleteModePaiementForm").attr("action", "/gestionnaire/mode_paiements/" + id);
});

//modification
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var nom = $(this).data("nom");
    var telephone = $(this).data("contact");

    // Update modal content
    $('#mod-name').text(nom);
    $('#editModal input[name="nom"]').val(nom);
    $('#editModal input[name="telephone"]').val(telephone);

    // Update form action
    $("#editModePaiementForm").attr("action", "/gestionnaire/mode_paiements/" + id);
});

//modification du type de facturation
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var libelle = $(this).data("libelle");
    $('#modifyfacturation input[name="libelle"]').val(libelle);
    $("#editFacturation").attr(
        "action",
        "/gestionnaire/type_facturations/" + id
    );
    if ($('#editFacturation input[name="_method"]').length === 0) {
        $("#editFacturation").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
    }
});

//suppression du type de facturation
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deletefacturationForm").attr(
        "action",
        "/gestionnaire/type_facturations/" + id
    );
});

//suppression du vetement
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deleteVetementForm").attr("action", "/gestionnaire/vetements/" + id);
});

$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deleteCategorieForm").attr("action", "/gestionnaire/categories/" + id);
});

//modification de la remise
$(document).on("click", ".update-btn", function () {
    var id = $(this).data("id");
    var valeur = $(this).data("valeur");
    var description = $(this).data("description");
    var type_remise = $(this).data("type_remise");

    $('#updateRemise input[name="valeur"]').val(valeur);
    $('#updateRemise textarea[name="description"]').val(description);
    if (type_remise === "fixe") {
        $('#updateRemise input[name="type_remise"][value="fixe"]').prop(
            "checked",
            true
        );
    } else {
        $('#updateRemise input[name="type_remise"][value="pourcentage"]').prop(
            "checked",
            true
        );
    }

    $("#updateRemiseForm").attr("action", "/gestionnaire/remises/" + id);

    if ($('#updateRemiseForm input[name="_method"]').length === 0) {
        $("#updateRemiseForm").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
    }
});

//suppression de la remise
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deleteRemiseForm").attr("action", "/gestionnaire/remises/" + id);
});

//modification du type de prestation
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var intitule = $(this).data("intitulle");
    var duree = $(this).data("duree");
    $('#modifyfacturation input[name="intitule"]').val(intitule);
    $('#modifyfacturation input[name="duree_moyenne"]').val(duree);
    $("#editFacturation").attr(
        "action",
        "/gestionnaire/type_prestations/" + id
    );
    if ($('#editFacturation input[name="_method"]').length === 0) {
        $("#editFacturation").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
    }
});

//suppression du type de prestation
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deleteprestationForm").attr(
        "action",
        "/gestionnaire/type_prestations/" + id
    );
});

//modification du pressing
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var nom = $(this).data("libelle");
    var adresse = $(this).data("adress");
    $('#modifypressing input[name="nom"]').val(nom);
    $('#modifypressing input[name="adresse"]').val(adresse);
    $("#editPressingForm").attr("action", "/gestionnaire/pressings/" + id);
    if ($('#editPressingForm input[name="_method"]').length === 0) {
        $("#editPressingForm").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
    }
});

//suppression du pressing
$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");
    $("#deletepressingForm").attr("action", "/gestionnaire/pressings/" + id);
});


//gestion du modal form payement
$(document).on("click", ".btn-card", function () {
    var commande_id = $(this).data("id");
    var montant = $(this).data("montant");
    $("#commande_id").val(commande_id);
    $("#montant").val(montant);
    $("#payementForm").attr("action", "/personnel/paiements");
});



//--#Code JS POUR LE TRAITEMENT DU FORMULAIRE DE COMMANDE#--
let vetementIndex = 0;
updatePrixUnitaireKilo();
// Recherche client
$("#client_search").on("input", function () {
    let search = $(this).val().toLowerCase();
    let matches = clients.filter((c) =>
        c.user.name.toLowerCase().includes(search)
    );
    let $suggestions = $("#clientSuggestions");
    $suggestions.empty();
    if (search && matches.length) {
        matches.forEach((c) => {
            $suggestions.append(
                `<button type="button" class="list-group-item list-group-item-action client-suggestion" data-id="${c.client_id}" data-name="${c.user.name}" data-lastname="${c.user.last_name}">${c.user.name} ${c.user.last_name}</button>`
            );
        });
        $suggestions.show();
        $("#showNewClientBtn").hide();
    } else if (search) {
        $suggestions.hide();
        $("#showNewClientBtn").show();
    } else {
        $suggestions.hide();
        $("#showNewClientBtn").hide();
    }
});
$(document).on("click", ".client-suggestion", function () {
    $("#client_id").val($(this).data("id"));
    $("#client_search").val(
        $(this).data("name") + " " + $(this).data("lastname")
    );
    $("#clientSuggestions").hide();
    $("#showNewClientBtn").hide();
    $("#newClientFields").hide();
    $("#newClientFields input").prop("required", false);
});
$("#showNewClientBtn").on("click", function () {
    $("#client_id").val("");
    $("#newClientFields").show();
    $("#newClientFields input").prop("required", true);
});

// Navigation multi-step
$(document).on("click", ".next-step", function () {
    let $current = $(this).closest(".step-form");
    let $next = $current.next(".step-form");
    $current.hide();
    $next.show();
});
$(document).on("click", ".prev-step", function () {
    let $current = $(this).closest(".step-form");
    let $prev = $current.prev(".step-form");
    $current.hide();
    $prev.show();
});

// Quand on change le type de prestation ou le type de facturation
function updatePrixUnitaireKilo() {
    let facturation = $("#type_facturation_id option:selected")
        .text()
        .toLowerCase();
    let prestationId = $("#type_prestation_id").val();
    let prestation = typePrestations.find(
        (p) => p.type_prestation_id == prestationId
    );

    if (facturation.includes("kilo") && prestation) {
        $("#prix_unitaire_kilo").val(prestation.cout_par_kilo);
        $("#prix_unitaire_kilo").prop("readonly", true);
    } else {
        $("#prix_unitaire_kilo").val("");
        $("#prix_unitaire_kilo").prop("readonly", false);
    }
}

$("#type_facturation_id, #type_prestation_id").on(
    "change",
    updatePrixUnitaireKilo
);

// Affichage dynamique selon le type de facturation
$("#type_facturation_id").on("change", function () {
    let selected = $(this).find("option:selected").text().toLowerCase();
    if (selected.includes("kilo") || selected.includes("poids")) {
        $("#poidsTotalField").show();
        $("#prixUnitaireKiloField").show();
        $("#poids_total, #prix_unitaire_kilo").prop("required", true);
        $("#step3").show();
        $("#nextToStep3").show();
        $("#submitKilo").hide();
        $("#prixUnitaireTh").hide();
        $("#vetementsTable tbody tr").each(function () {
            $(this).find(".prix-unitaire-td").hide();
            $(this)
                .find(".prix-unitaire-input")
                .prop("required", false)
                .val("");
        });
    } else if (selected.includes("vetement")) {
        $("#poidsTotalField").hide();
        $("#prixUnitaireKiloField").hide();
        $("#poids_total, #prix_unitaire_kilo").prop("required", false).val("");
        $("#step3").show();
        $("#nextToStep3").show();
        $("#submitKilo").hide();
        $("#prixUnitaireTh").show();
        $("#vetementsTable tbody tr").each(function () {
            $(this).find(".prix-unitaire-td").show();
            $(this).find(".prix-unitaire-input").prop("required", true);
        });
    } else {
        $("#poidsTotalField").hide();
        $("#prixUnitaireKiloField").hide();
        $("#poids_total, #prix_unitaire_kilo").prop("required", false).val("");
        $("#step3").hide();
        $("#nextToStep3").show();
        $("#submitKilo").hide();
    }
});

// Date livraison affichée seulement pour prestation express
$("#type_prestation_id").on("change", function () {
    let selected = $(this).find("option:selected").text().toLowerCase();
    if (selected.includes("express")) {
        $("#dateLivraisonField").show();
        $("#date_livraison").prop("required", true);
    } else {
        $("#dateLivraisonField").hide();
        $("#date_livraison").prop("required", false).val("");
    }
});

// Ajout/suppression de ligne vêtement
function createVetementRow()
{
    return `<tr>
        <td>
            <input type="text" class="form-control vetement-search" name="vetements[${vetementIndex}][type]" autocomplete="off" placeholder="Nom du vêtement">
            <div class="vetement-suggestions"></div>
            <input type="hidden" name="vetements[${vetementIndex}][vetement_id]" class="vetement-id">
        </td>
        <td><input type="number" min="1" name="vetements[${vetementIndex}][quantite]" class="form-control"></td>
        <td><input type="text" name="vetements[${vetementIndex}][description]" class="form-control"></td>
        <td class="prix-unitaire-td" style="display:none;">
            <input type="number" step="0.01" min="0" name="vetements[${vetementIndex}][prix_unitaire]" class="form-control prix-unitaire-input" readonly>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm remove-vetement-row"><i class="bi bi-trash"></i></button></td>
    </tr>`;
}

$("#addVetementRow").on("click", function () {
    $("#vetementsTable tbody").append(createVetementRow());
    let selected = $("#type_facturation_id")
        .find("option:selected")
        .text()
        .toLowerCase();
    if (selected.includes("vetement")) {
        $("#vetementsTable tbody tr:last .prix-unitaire-td").show();
        $("#vetementsTable tbody tr:last .prix-unitaire-input").prop(
            "required",
            true
        );
    }
    vetementIndex++;
});

$(document).on("click", ".remove-vetement-row", function () {
    $(this).closest("tr").remove();
});

// Recherche assistée vêtements
function getVetementOptions(search = "") {
    if (!search) return vetements;
    return vetements.filter((v) =>
        v.type.toLowerCase().includes(search.toLowerCase())
    );
}
$(document).on("input", ".vetement-search", function () {
    let $input = $(this);
    let search = $input.val();
    let options = getVetementOptions(search);
    let $suggestions = $input.siblings(".vetement-suggestions");
    $suggestions.empty();
    if (search && options.length) {
        options.forEach((v) => {
            $suggestions.append(
                `<div class="suggestion-item" data-id="${v.vetement_id}" data-type="${v.type}" data-prix="${v.prix_unitaire}">${v.type} - ${v.categorie.intitule}</div>`
            );
        });
        $suggestions.show();
    } else {
        $suggestions.hide();
    }
});
$(document).on("click", ".suggestion-item", function () {
    let $item = $(this);
    let $input = $item.closest("td").find(".vetement-search");
    let vetementId = $item.data("id");
    let vetementType = $item.data("type");
    let prixUnitaire = $item.data("prix");
    $input.val(vetementType);
    $input.siblings(".vetement-id").val(vetementId);
    $input.siblings(".vetement-suggestions").hide();

    // Remplir et bloquer le champ prix unitaire si facturation par vêtement
    let selected = $("#type_facturation_id")
        .find("option:selected")
        .text()
        .toLowerCase();
    let $prixInput = $item.closest("tr").find(".prix-unitaire-input");
    if (selected.includes("vetement")) {
        $prixInput.val(prixUnitaire);
        $prixInput.prop("readonly", true);
    } else {
        $prixInput.val("");
        $prixInput.prop("readonly", false);
    }
});

$(document).on("click", function (e) {
    if (!$(e.target).hasClass("vetement-search")) {
        $(".vetement-suggestions").hide();
    }
});
//Fin du code pour la gestion du formulaire d'enregistrement d'une commande

//code de gestion de la livraison partielle
// $(document).on('click', '.btn-partiellement', function () {
//     let vetements = $(this).data('vetements');

//     console.log(vetements);

//     let commandeId = $(this).data('commande-id');
//     let html = '';

//     $.each(vetements, function (index, item) {
//         let restant = item.quantite - item.quantite_livree;
//         html += `
//             <tr>
//                 <td>${item.type}</td>
//                 <td>${item.quantite}</td>
//                 <td>${item.quantite_livree}</td>
//                 <td>
//                     <input type="number"
//                            name="livraisons[${item.vetement_id}]"
//                            class="form-control"
//                            min="0"
//                            max="${restant}"
//                            value="0"
//                            required>
//                 </td>
//             </tr>`;
//     });

//     // Injecter dans le tableau du modal
//     $('#livraisonPartielleTableBody').html(html);

//     // Mettre à jour l'action du formulaire du modal avec l'ID de la commande
//     $('#formLivraisonPartielle').attr('action', '/commandes/' + commandeId + '/livraison-partielle');
// });

