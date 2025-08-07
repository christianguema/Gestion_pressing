<div class="modal fade" id="paiementCard" tabindex="-1" aria-labelledby="paiementCardLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paiementCardLabel">Détails du paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paiementForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="commande_id" id="commande_id">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="mode_paiement" class="form-label">Mode de paiement</label>
                        <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                            <option value="" selected disabled>Sélectionner</option>
                            <option value="MixByYass">MixByYass</option>
                            <option value="MoovMoney">MoovMoney</option>
                            <option value="En espèces">En espèces</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_paiement" class="form-label">Date de paiement</label>
                        <input type="date" class="form-control" id="date_paiement" name="date_paiement" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirmer le paiement</button>
                </form>
            </div>
        </div>
    </div>
</div>
