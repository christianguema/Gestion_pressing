@extends('layouts.base')
@section('title', 'Modifier le Type de Facturation')

@section('content')
    <div class="container">
        <h1>Modifier le Type de Facturation</h1>

        <form action="{{ route('type_facturations.update', $typeFacturation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé</label>
                <input type="text" class="form-control @error('libelle') is-invalid @enderror"
                       id="libelle" name="libelle" value="{{ old('libelle', $typeFacturation->libelle) }}" required>
                @error('libelle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('type_facturations.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection