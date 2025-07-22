<!-- Modal Erreur -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="text-white modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title">Erreur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
</div>
