@extends('layouts.base')

@section('title', "Enregistrer un paiement")

@section('content')
<div class="pagetitle">
    <h1>ENREGISTRER PAIEMENT</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('paiements.create') }}">Paiements</a></li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('paiements.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant" name="montant" required>
            </div>

            <div class="mb-3">
                <label for="mode_paiement" class="form-label">Mode de paiement</label>
                <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                    <option value="">Sélectionner un mode de paiement</option>
                    <option value="MoovMoney">MoovMoney</option>
                    <option value="MixByYass">MixByYass</option>
                    <option value="EnEspeces">En espèces</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="date_paiement" class="form-label">Date de paiement</label>
                <input type="date" class="form-control" id="date_paiement" name="date_paiement" required>
            </div>

            <div class="mb-3">
                <label for="commande_id" class="form-label">Commande</label>
                <select id="commande_id" class="form-select @error('commande_id') is-invalid @enderror"
                    name="commande_id" required>
                    <option disabled selected>Choisir une commande</option>
                    @foreach ($commandes as $commande)
                    <option value="{{ $commande->commande_id }}" {{ old('commande_id')==$commande->commande_id ?
                    'selected' : '' }}>
                      Date :{{ $commande->date_reception }} - Montant :{{ $commande->montant_total}}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>

@endsection
