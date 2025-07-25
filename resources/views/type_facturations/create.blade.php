@extends('layouts.base')

@section('title', 'Ajouter un Type de Facturation')

@section('content')

@if(session('success'))
    @include('components.alertModals.success')
@endif

@if(session('error'))
    @include('components.alertModals.error')
@endif


<div class="pagetitle">
      <h1>AJOUTER UN TYPE DE FACTURATION</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('type_facturations.index') }}">Type de Facturation</a></li>
          <li class="breadcrumb-item active">Ajouter</li>
        </ol>
      </nav>
</div>

<div class="container">
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
