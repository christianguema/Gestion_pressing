<div class="modal fade" id="updateRemise" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteprojectLabel">Modifier la remise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id='updateRemiseForm' action="" method="POST">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="valeur" class="form-label">Valeur</label>
                        <input type="number" step="0.1" name="valeur" class="form-control" id="valeur">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="type_remise" name="type_remise"  value="fixe">
                            <label class="form-check-label" for="type_remise">
                                Fixe
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="type_remise" type="radio" name="type_remise"  value="pourcentage">
                            <label class="form-check-label" for="type_remise">
                                Pourcentage
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

