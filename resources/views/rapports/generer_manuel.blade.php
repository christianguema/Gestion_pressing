@extends('layouts.base')

@section('title', 'Générer des Rapports Manuellement')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Générer des Rapports Manuellement</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('rapports.generer.traiter') }}" id="generateForm">
                        @csrf

                        <div class="mb-4">
                            <label for="pressing_id" class="form-label">Pressing (optionnel)</label>
                            <select name="pressing_id" id="pressing_id" class="form-control">
                                <option value="">Tous les pressings</option>
                                @foreach($pressings as $pressing)
                                    <option value="{{ $pressing->pressing_id }}" {{ old('pressing_id') == $pressing->pressing_id ? 'selected' : '' }}>
                                        {{ $pressing->nom }} - {{ $pressing->adresse }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Laissez vide pour générer les rapports de tous les pressings
                            </small>
                            @error('pressing_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control"
                                   value="{{ old('date_debut') }}" required max="{{ now()->format('Y-m-d') }}">
                            @error('date_debut')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_fin" class="form-label">Date de fin <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control"
                                   value="{{ old('date_fin') }}" required max="{{ now()->format('Y-m-d') }}">
                            @error('date_fin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Attention :</strong>
                            <ul class="mt-2 mb-0">
                                <li>Cette opération va créer des rapports pour chaque jour de la période sélectionnée</li>
                                <li>Les rapports existants ne seront pas écrasés</li>
                                <li>La période ne peut pas dépasser 1 an</li>
                                <li>Seules les commandes avec des paiements seront comptabilisées dans les revenus</li>
                            </ul>
                        </div>

                        <div id="estimation" class="alert alert-info" style="display: none;">
                            <i class="fas fa-info-circle"></i>
                            <span id="estimation-text"></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rapports.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>

                            <button type="submit" class="btn btn-warning" id="submitBtn">
                                <i class="fas fa-cogs"></i> Générer les Rapports
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebutInput = document.getElementById('date_debut');
        const dateFinInput = document.getElementById('date_fin');
        const pressingSelect = document.getElementById('pressing_id');
        const estimationDiv = document.getElementById('estimation');
        const estimationText = document.getElementById('estimation-text');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('generateForm');

        function updateEstimation() {
            const dateDebut = dateDebutInput.value;
            const dateFin = dateFinInput.value;

            if (dateDebut && dateFin) {
                const debut = new Date(dateDebut);
                const fin = new Date(dateFin);
                const diffTime = Math.abs(fin - debut);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                if (diffDays > 365) {
                    estimationDiv.className = 'alert alert-danger';
                    estimationText.textContent = 'Erreur : La période ne peut pas dépasser 1 an (365 jours).';
                    estimationDiv.style.display = 'block';
                    submitBtn.disabled = true;
                    return;
                }

                const nombrePressings = pressingSelect.value ? 1 : {{ $pressings->count() }};
                const estimationRapports = diffDays * nombrePressings;

                estimationDiv.className = 'alert alert-info';
                estimationText.textContent = `Estimation : ${estimationRapports} rapports maximum à créer sur ${diffDays} jour(s) pour ${nombrePressings} pressing(s).`;
                estimationDiv.style.display = 'block';
                submitBtn.disabled = false;
            } else {
                estimationDiv.style.display = 'none';
                submitBtn.disabled = false;
            }
        }

        // Validation des dates
        dateDebutInput.addEventListener('change', function() {
            if (dateFinInput.value && this.value > dateFinInput.value) {
                dateFinInput.value = this.value;
            }
            dateFinInput.min = this.value;
            updateEstimation();
        });

        dateFinInput.addEventListener('change', function() {
            if (dateDebutInput.value && this.value < dateDebutInput.value) {
                dateDebutInput.value = this.value;
            }
            updateEstimation();
        });

        pressingSelect.addEventListener('change', updateEstimation);

        // Confirmation avant soumission
        form.addEventListener('submit', function(e) {
            const dateDebut = dateDebutInput.value;
            const dateFin = dateFinInput.value;

            if (dateDebut && dateFin) {
                const debut = new Date(dateDebut);
                const fin = new Date(dateFin);
                const diffTime = Math.abs(fin - debut);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                if (diffDays > 30) {
                    if (!confirm(`Vous êtes sur le point de générer des rapports pour ${diffDays} jours. Cette opération peut prendre du temps. Voulez-vous continuer ?`)) {
                        e.preventDefault();
                        return false;
                    }
                }
            }

            // Désactiver le bouton pour éviter les doubles soumissions
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération en cours...';
        });
    });
</script>
@endsection
