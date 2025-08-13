<div class="modal fade" id="livraisonPartielleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Livraison Partielle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="livraisonPartielleForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vetement</th>
                                <th>Quantité Totale</th>
                                <th>Déjà Livré</th>
                                <th>Quantité à Livrer</th>
                            </tr>
                        </thead>
                        <tbody id="livraisonPartielleTableBody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider la livraison</button>
                </div>
            </form>
        </div>
    </div>
</div>
