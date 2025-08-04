@extends('layouts.base')

@section('title', 'Modifier le Vêtement')

@section('content')
    <div class="pagetitle">
        <h1>MODIFIER UN VÊTEMENT</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vetements.index') }}">Vêtements</a></li>
                <li class="breadcrumb-item active">Modifier</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Modifier "{{ $vetement->type }}"</h5>

            <form action="{{ route('vetements.update', $vetement) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="type" class="form-label">Type de vêtement</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror"
                           id="type" name="type" value="{{ old('type', $vetement->type) }}" required>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prix_unitaire" class="form-label">Prix unitaire (Frcfa)</label>
                    <input type="number" step="0.01" class="form-control @error('prix_unitaire') is-invalid @enderror"
                           id="prix_unitaire" name="prix_unitaire" value="{{ old('prix_unitaire', $vetement->prix_unitaire) }}">
                    @error('prix_unitaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $vetement->categorie_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->intitule }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('vetements.index') }}" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
@endsection
