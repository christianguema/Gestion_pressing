<div class="modal fade" id="deletetypeprestation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteprojectLabel">Supprimer la prestation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body justify-content-center flex-column d-flex">
                <i class="mt-2 text-center icofont-ui-delete text-danger display-2"></i>
                <p class="mt-4 text-center fs-5">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer ce type?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NON</button>
                <form id="deleteprestationForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger color-fff">OUI</button>
                </form>
            </div>
        </div>
    </div>
</div>
