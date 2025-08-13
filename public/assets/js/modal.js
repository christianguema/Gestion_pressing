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

