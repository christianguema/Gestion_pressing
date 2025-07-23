@extends('layouts.base')
@section('title', 'Ajouter un Type de Facturation')

@section('content')
    <div class="container">
        <h1>Ajouter un Type de Facturation</h1>

        <form action="{{ route('type_facturations.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé</label>
                <input type="text" class="form-control @error('libelle') is-invalid @enderror"
                       id="libelle" name="libelle" value="{{ old('libelle') }}" required>
                @error('libelle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="{{ route('type_facturations.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection