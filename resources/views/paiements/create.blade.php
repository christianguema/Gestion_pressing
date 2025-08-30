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
                <input type="" class="form-control" id="montant" name="montant" required>
            </div>

            <div class="mb-3">
                <label for="mode_paiement" class="form-label">Mode de paiement</label>
                <select class="form-select" id="mode_paiement" name="mode_paiement_id" required>
                    <option value=" " selected disabled>Sélectionner un mode de paiement</option>
                    @forelse ($modes as $item)
                        <option value="{{ $item->mode_paiement_id }}">{{ $item->nom }} - Tel:{{ $item->telephone }}</option>
                    @empty
                        <option value=" " disabled>MoovMoney</option>
                    @endforelse
                </select>
            </div>

            @foreach ($modes as $mode)
                @if($mode !== 'En espèce'||$mode !== 'en espèce'|| $mode !== 'En espece')
                    <div class="mb-3" id="reference_field" style="display: none;">
                        <label for="reference_transaction" class="form-label">Référence de la transaction</label>
                        <input type="number" class="form-control" id="reference_transaction"
                            name="reference_transaction">
                        <small class="form-text text-muted">Numéro de reférence transaction pour les paiements
                            mobiles</small>
                    </div>
                @endif
            @endforeach

            <div class="mb-3">
                <label for="date_paiement" class="form-label">Date de paiement</label>
                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" id="date_paiement" name="date_paiement" required>
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
