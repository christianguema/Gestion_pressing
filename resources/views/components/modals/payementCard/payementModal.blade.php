<div class="modal fade" id="payementCard" tabindex="-1" aria-labelledby="payementCardLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payementCardLabel">Détails du paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payementForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="commande_id" id="commande_id">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="mode_paiement" class="form-label">Mode de paiement</label>
                        <select class="form-select" id="mode_paiement" name="mode_paiement_id" required>
                            <option value="" selected disabled>Sélectionner</option>
                            <!-- Les options seront injectées par JS -->
                        </select>
                    </div>
                    <div class="mb-3" id="reference_field" style="display: none;">
                        <label for="reference_transaction" class="form-label">Référence de la transaction</label>
                        <input type="number" class="form-control" id="reference_transaction"
                            name="reference_transaction">
                        <small class="form-text text-muted">Numéro de reférence transaction pour les paiements
                            mobiles</small>
                    </div>
                    <div class="mb-3">
                        <label for="date_paiement" class="form-label">Date de paiement</label>
                        <input type="date" class="form-control" id="date_paiement" name="date_paiement"
                            value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirmer le paiement</button>
                </form>
            </div>
        </div>
    </div>
</div>
