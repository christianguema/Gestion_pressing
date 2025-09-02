//code pour la recherche des commandes
$(document).ready(function() {
    let typingTimer;
    const doneTypingInterval = 500;

    $('input[name="search"]').on('keyup', function() {
        clearTimeout(typingTimer);
        const searchForm = $(this).closest('form');
        const searchValue = $(this).val();

        typingTimer = setTimeout(function() {
            // Réinitialiser les autres filtres
            searchForm.find('select[name="pressing_id"]').val('');
            searchForm.find('select[name="status"]').val('En_attente');
            searchForm.find('select[name="filter"]').val('today');

            // Construire l'URL avec uniquement le paramètre de recherche
            const baseUrl = searchForm.attr('action');
            const searchUrl = baseUrl + '?search=' + encodeURIComponent(searchValue);

            // Rediriger vers l'URL de recherche
            window.location.href = searchUrl;
        }, doneTypingInterval);
    });

    $('input[name="search"]').on('keydown', function() {
        clearTimeout(typingTimer);
    });

    // Gérer le clic sur le bouton Filtrer séparément
    $('button[type="submit"]').on('click', function(e) {
        // Si le champ de recherche est vide, permettre le filtrage normal
        if (!$('input[name="search"]').val()) {
            return true;
        }
        e.preventDefault();
    });
});
