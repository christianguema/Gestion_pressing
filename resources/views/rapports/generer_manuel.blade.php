@extends('layouts.base')

@section('title', 'Générer Rapport Manuellement')

@section('content')
<div class="container">
    <h2>Générer un rapport entre deux dates</h2>

    <form method="POST" action="{{ route('rapports.generer.traiter') }}">
        @csrf
        <div class="form-group">
            <label>Pressing (optionnel)</label>
            <select name="pressing_id" class="form-control">
                <option value="">Tous les pressings</option>
                @foreach($pressings as $pressing)
                    <option value="{{ $pressing->pressing_id }}">{{ $pressing->nom }} , {{ $pressing->adresse }} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Date de début</label>
            <input type="date" name="date_debut" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date de fin</label>
            <input type="date" name="date_fin" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Générer</button>
        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
