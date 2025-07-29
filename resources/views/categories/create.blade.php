@extends('layouts.base')

@section('title', 'Ajouter une Catégorie')

@section('content')
    <div class="pagetitle">
        <h1>CRÉER UNE CATÉGORIE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
                <li class="breadcrumb-item active">Créer</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nouvelle Catégorie</h5>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="intitule" class="form-label">Nom de la catégorie</label>
                    <input type="text" class="form-control @error('intitule') is-invalid @enderror"
                           id="intitule" name="intitule" value="{{ old('intitule') }}" required>
                    @error('intitule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
