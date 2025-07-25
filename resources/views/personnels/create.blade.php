@extends('layouts.base')
@section('title','Ajouter un personnel')
@section('content')

<div class="pagetitle">
    <h1>PERSONNELS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('personnels.index')}}">Personnels</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">

        <!-- Vertical Form -->
        <form method="POST" action="{{ route('personnels.store') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            {{-- Nom --}}
            <div class="col-md-6">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>

            {{-- Prenom --}}
            <div class="col-md-6">
                <label for="lastname" class="form-label">Prenom</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('lastname') }}">
            </div>

            {{-- Date de naissance --}}
            <div class="col-md-6">
                <label for="birthday" class="form-label">Date De Naissance</label>
                <input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                    id="birthday" value="{{ old('birthday') }}">
                @error('birthday')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Telephone --}}
            <div class="col-md-6">
                <label for="contact" class="form-label">Téléphone</label>
                <input type="tel" class="form-control @error('contact') is-invalid @enderror" name="contact"
                    id="contact" value="{{ old('contact') }}">
                @error('contact')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Adresse --}}
            <div class="col-md-6">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="1234 Main St"
                    value="{{ old('adresse') }}">
            </div>

            {{-- Password --}}
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            {{-- Confirmer password --}}
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    required>
            </div>

            {{-- Photo de profil --}}
            <div class="col-md-6">
                <label for="profilImage" class="form-label">Photo de profil</label>
                <input type="file" class="form-control @error('profilImage') is-invalid @enderror" id="profilImage"
                    name="profilImage" accept="image/*">
                @error('profilImage')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Assignation d'un pressing au personnel créé --}}
            <div class="col-md-6">
                <label for="pressing_id" class="form-label">Pressings</label>
                <select id="pressing_id" class="form-select @error('pressing_id') is-invalid @enderror"
                    name="pressing_id" required>
                    <option disabled {{ old('pressing_id') ? '' : 'selected' }}>Choose...</option>
                    @foreach ($pressings as $pressing)
                    <option value="{{ $pressing->pressing_id }}" {{ old('pressing_id')==$pressing->pressing_id ?
                        'selected' : '' }}>
                        {{ $pressing->nom }} - {{ $pressing->adresse }}
                    </option>
                    @endforeach
                </select>
                @error('pressing_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Assignation d'un poste au personnel --}}
            <div class="col-md-12">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" class="form-control @error('poste') is-invalid @enderror" id="poste" name="poste"
                    placeholder="Caissier" value="{{ old('poste') }}">
                @error('poste')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- boutton de validation --}}
            <div class="text-center">
                <button type="reset" class="btn btn-secondary">Annuler</button>
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </form>

    </div>
</div>

@endsection
