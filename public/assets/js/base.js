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

var successModal = new bootstrap.Modal(document.getElementById('successModal'));
successModal.show();

var errorModal = new bootstrap.Moda(document.getElementById('errorModal'));
errorModal.show();
