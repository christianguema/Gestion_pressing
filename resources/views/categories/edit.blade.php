@extends('layouts.base')

@section('title', 'Modifier la Catégorie')

@section('content')
    <div class="pagetitle">
        <h1>MODIFIER UNE CATÉGORIE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
                <li class="breadcrumb-item active">Modifier</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Modifier "{{ $categorie->intitule }}"</h5>

            <form action="{{ route('categories.update', $categorie) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="intitule" class="form-label">Nom de la catégorie</label>
                    <input type="text" class="form-control @error('intitule') is-invalid @enderror"
                           id="intitule" name="intitule" value="{{ old('intitule', $categorie->intitule) }}" required>
                    @error('intitule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
@endsection
