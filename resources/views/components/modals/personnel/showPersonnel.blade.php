<div class="modal fade" id="viewPersonnelModal" tabindex="-1" aria-labelledby="viewPersonnelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="text-white modal-header bg-primary">
                <h5 class="modal-title" id="viewPersonnelModalLabel">Détails du personnel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <div class="text-center col-md-4">
                        <img id="personnel-image" src="{{ asset('assets/img/default-avatar.png') }}"
                            alt="Photo de profil" class="mb-3 img-fluid rounded-circle"
                            style="width:120px; height:120px; object-fit:cover;">
                        <h5 class="mt-2" id="personnel-nom"></h5>
                        <span class="badge bg-info" id="personnel-poste"></span>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Email :</strong> <span id="personnel-email"></span></li>
                            <li class="list-group-item"><strong>Téléphone :</strong> <span id="personnel-contact"></span></li>
                            <li class="list-group-item"><strong>Date de naissance :</strong> <span id="personnel-birthday"></span></li>
                            <li class="list-group-item"><strong>Poste :</strong> <span id="personnel-poste"></span></li>
                            <li class="list-group-item"><strong>Pressing assigné :</strong> <span id="personnel-pressing"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
