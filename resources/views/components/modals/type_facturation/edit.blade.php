<div class="modal fade" id="modifyfacturation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="leaveaddLabel">Modifier type de facturation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFacturation" action="" method="POST">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="libelle" class="form-label">Libellé</label>
                        <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" required>
                        @error('libelle')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
