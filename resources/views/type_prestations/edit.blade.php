@extends('layouts.base')
@section('title', 'Modifier le Type de Prestation')

@section('content')
    <div class="container">
        <h1>Modifier le Type de Prestation</h1>

        <form action="{{ route('type_prestations.update', $typePrestation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="intitule" class="form-label">Intitulé</label>
                <input type="text" class="form-control @error('intitule') is-invalid @enderror"
                       id="intitule" name="intitule" value="{{ old('intitule', $typePrestation->intitule) }}" required>
                @error('intitule')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Coût par kilo fixe -->
            <div class="mb-3">
                <label for="cout_par_kilo" class="form-label">Coût de prestation par kilo (Fcfa)</label>
                <input type="number" class="form-control @error('cout_par_kilo') is-invalid @enderror"
                       id="cout_par_kilo" name="cout_par_kilo"
                       value="{{ old('cout_par_kilo', $typePrestation->cout_par_kilo) }}"
                       step="0.01" min="0" placeholder="Ex : 2500.00">
                <small class="text-muted">Coût fixe appliqué par kilogramme.</small>
                @error('cout_par_kilo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="duree_moyenne" class="form-label">Durée moyenne (jours)</label>
                <input type="number" class="form-control @error('duree_moyenne') is-invalid @enderror"
                    id="duree_moyenne" name="duree_moyenne"
                    value="{{ old('duree_moyenne', $typePrestation->duree_moyenne) }}" min="0" step="1">
                <small class="text-muted">Laisser vide si non applicable.</small>
                @error('duree_moyenne')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('type_prestations.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection