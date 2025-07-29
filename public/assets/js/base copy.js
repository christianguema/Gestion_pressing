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
    $("#personnel-email").text($(this).data("email"));
    $("#personnel-contact").text($(this).data("contact"));
    $("#personnel-pressing").text($(this).data("pressing"));
    $("#personnel-birthday").text($(this).data("datenaissance"));
});

//modification du type de facturation
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var libelle = $(this).data("libelle");
    // Remplit les champs du modal
    $('#modifyfacturation input[name="libelle"]').val(libelle);

    // Met à jour l'action du formulaire
    $("#editFacturation").attr(
        "action",
        "/gestionnaire/type_facturations/" + id
    );
    // Ajoute le spoofing method PUT si besoin
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

//modification du type de prestation
$(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var intitule = $(this).data("intitulle");
    var duree = $(this).data("duree");
    // Remplit les champs du modal
    $('#modifyfacturation input[name="intitule"]').val(intitule);
    $('#modifyfacturation input[name="duree_moyenne"]').val(duree);

    // Met à jour l'action du formulaire
    $("#editFacturation").attr(
        "action",
        "/gestionnaire/type_prestations/" + id
    );
    // Ajoute le spoofing method PUT si besoin
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
    // Remplit les champs du modal
    $('#modifypressing input[name="nom"]').val(nom);
    $('#modifypressing input[name="adresse"]').val(adresse);
    // Met à jour l'action du formulaire
    $("#editPressingForm").attr("action", "/gestionnaire/pressings/" + id);
    // Ajoute le spoofing method PUT si besoin
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


//--#Code JS POUR LE TRAITEMENT DU FORMULAIRE DE COMMANDE#--
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

// Sélection d'un client existant
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

// Affiche le formulaire d'ajout du client si on clique sur le bouton
$("#showNewClientBtn").on("click", function () {
    $("#client_id").val("");
    $("#newClientFields").show();
    $("#newClientFields input").prop("required", true);
});

// Affichage dynamique selon le type de facturation
$("#type_facturation_id").on("change", function () {
    let selected = $(this).find("option:selected").text().toLowerCase();
    if (selected.includes("kilo") || selected.includes("poids")) {
        $("#poidsTotalField").show();
        $("#prixUnitaireKiloField").show();
        $("#poids_total, #prix_unitaire_kilo").prop("required", true);
        $("#step3").hide();
        $("#nextToStep3").hide();
        $("#submitKilo").show();
    } else {
        $("#poidsTotalField").hide();
        $("#prixUnitaireKiloField").hide();
        $("#poids_total, #prix_unitaire_kilo").prop("required", false).val("");
        $("#step3").show();
        $("#nextToStep3").show();
        $("#submitKilo").hide();
    }

    // Affiche ou cache le champ prix unitaire dans la table vêtements
    if (selected.includes("vetement")) {
        $("#prixUnitaireTh").show();
        $("#vetementsTable tbody tr").each(function () {
            $(this).find(".prix-unitaire-td").show();
            $(this).find(".prix-unitaire-input").prop("required", true);
        });
    } else {
        $("#prixUnitaireTh").hide();
        $("#vetementsTable tbody tr").each(function () {
            $(this).find(".prix-unitaire-td").hide();
            $(this)
                .find(".prix-unitaire-input")
                .prop("required", false)
                .val("");
        });
    }
});

// Multi-step navigation
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

// Client: afficher les champs de création si aucun client sélectionné
// $("#client_id").on("change", function () {
//     if (!$(this).val()) {
//         $("#newClientFields").show();
//         $("#newClientFields input").prop("required", true);
//     } else {
//         $("#newClientFields").hide();
//         $("#newClientFields input").prop("required", false);
//     }
// });

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

// Affichage du champ poids total uniquement pour facturation par poids
$("#type_facturation_id").on("change", function () {
    let selected = $(this).find("option:selected").text().toLowerCase();
    if (selected.includes("kilo") || selected.includes("poids")) {
        $("#poidsTotalField").show();
        $("#poids_total").prop("required", true);
    } else {
        $("#poidsTotalField").hide();
        $("#poids_total").prop("required", false).val("");
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
            <input type="number" step="0.01" min="0" name="vetements[][prix_unitaire]" class="form-control prix-unitaire-input" readonly>
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
});

let vetementIndex = 0;
function createVetementRow() {
    return `<tr>
        <td>
            <input type="text" class="form-control vetement-search" name="vetements[${vetementIndex}][type]" autocomplete="off" placeholder="Nom du vêtement">
            <div class="vetement-suggestions"></div>
            <input type="hidden" name="vetements[${vetementIndex}][vetement_id]" class="vetement-id">
        </td>
        <td><input type="number" min="1" name="vetements[${vetementIndex}][quantite]" class="form-control"></td>
        <td><input type="text" name="vetements[${vetementIndex}][couleur_vetement]" class="form-control"></td>
        <td class="prix-unitaire-td" style="display:none;">
            <input type="number" step="0.01" min="0" name="vetements[${vetementIndex}][prix_unitaire]" class="form-control prix-unitaire-input" readonly>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm remove-vetement-row"><i class="bi bi-trash"></i></button></td>
    </tr>`;
}

$("#addVetementRow").on("click", function () {
    $("#vetementsTable tbody").append(createVetementRow());
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
                `<div class="suggestion-item" data-id="${v.vetement_id}" data-type="${v.type}" data-prix="${v.prix_unitaire}">${v.type}</div>`
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

    // Remplir et bloquer le champ prix unitaire
    let $prixInput = $item.closest("tr").find(".prix-unitaire-input");
    $prixInput.val(prixUnitaire);
    $prixInput.prop("readonly", true);
});

$(document).on("click", function (e) {
    if (!$(e.target).hasClass("vetement-search")) {
        $(".vetement-suggestions").hide();
    }
});
//--#Code JS POUR LE TRAITEMENT DU FORMULAIRE DE COMMANDE#--

// Affichage des modals de succès et d'erreur
var successModalEl = document.getElementById("successModal");
if (successModalEl) {
    var successModal = new bootstrap.Modal(successModalEl);
    successModal.show();
}

var errorModalEl = document.getElementById("errorModal");
if (errorModalEl) {
    var errorModal = new bootstrap.Modal(errorModalEl);
    errorModal.show();
}
