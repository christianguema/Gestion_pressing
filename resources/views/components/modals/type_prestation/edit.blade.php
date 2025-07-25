<div class="modal fade" id="modifyfacturation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="leaveaddLabel">Modifier type de prestation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFacturation" action="" method="POST">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="intitule" class="form-label">Libellé</label>
                        <input type="text" class="form-control @error('intitule') is-invalid @enderror" id="intitule" name="intitule" required>
                        @error('intitule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="duree_moyenne" class="form-label">Durée moyenne</label>
                        <input type="text" class="form-control @error('duree_moyenne') is-invalid @enderror" id="duree_moyenne" name="duree_moyenne" required>
                        @error('duree_moyenne')
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
