{{-- filepath: resources/views/commandes/show.blade.php --}}
@extends('layouts.base')

@section('title', 'Detail commande')

@section('content')

<div class="pagetitle">
    <h1>Détails de la Commande</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('commandes.pendingIndex') }}">Commandes</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>
</div>

<div class="mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Informations Générales</h5>
        <p><strong>Nom complet du Client:</strong> {{ $commande->client->user->name }} {{ $commande->client->user->last_name }}</p>
        @role('gestionnaire')
            <p><strong>Personnel:</strong> {{ $commande->personnel->user->name ?? '-' }}</p>
            <p><strong>Pressing:</strong> {{ $commande->pressing->nom }}</p>
        @endrole
        <p><strong>Type de facturation:</strong> {{ $commande->typeFacturation->libelle ?? '-' }}</p>
        <p><strong>Type de prestation:</strong> {{ $commande->typePrestation->intitule ?? '-' }}</p>
        <p><strong>Date de Réception:</strong> {{ $commande->date_reception ? \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-' }}</p>
        <p><strong>Date de Livraison:</strong> {{ $commande->date_livraison ? \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') : '-' }}</p>
        <p><strong>État:</strong> {{ $commande->etat }}</p>
        @if($commande->paiement)
            <p><strong>Paiement:</strong> {{ $commande->paiement->mode_paiement }} ({{ $commande->paiement->montant }})</p>
        @else
            <p><strong>Paiement:</strong> Non payé</p>
        @endif

        @if($remise)
            <p><strong>Remise:</strong> {{ $remise->description }} ({{ $remise->type == 'pourcentage' ? $remise->valeur.'%' : $remise->valeur.' FCFA' }})</p>
            <p><strong>Montant Remise:</strong> {{ $montantRemise }} FCFA</p>
        @endif
        <p><strong>Montant A Payer:</strong> {{ $commande->montant_total }} FCFA</p>

    </div>
</div>

<div class="mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Articles de la Commande</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Description</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vetements as $article)
                <tr>
                    <td>{{ $article->type }}</td>
                    <td>{{ $article->pivot->quantite }}</td>
                    <td>{{ $article->pivot->description }}</td>
                    <td>
                        @if(str_contains(strtolower($commande->typeFacturation->libelle ?? ''), 'kilo'))
                            {{ $commande->prix_unitaire_kilo ?? '-' }}
                        @else
                            {{ $article->pivot->prix_unitaire ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if(str_contains(strtolower($commande->typeFacturation->libelle ?? ''), 'kilo'))
                            {{ ($commande->prix_unitaire_kilo ?? 0) * ($article->pivot->quantite ?? 0) }}
                        @else
                            {{ ($article->pivot->prix_unitaire ?? 0) * ($article->pivot->quantite ?? 0) }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mb-3 card">
    @if($commande->paiement)
        @if($commande->etat !== "Livré")
            <div class="card-body">
                <h5 class="card-title">Actions</h5>
                <form action="{{ route('commandes.changeStatus', $commande->commande_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="status" class="form-label">Changer l'état de la commande</label>
                        <select class="form-select" id="status" name="status" required>
                            @foreach($nextStatuses[$commande->etat] ?? [] as $status)
                            <option value="{{ $status }}" {{ $commande->etat === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Mettre à jour l'état</button>
                        <a href="{{ route('commandes.pendingIndex') }}" class="mt-3 btn btn-secondary">Retour</a>
                    </div>
                </form>
            </div>
        @endif
        {{-- boutton de telechargement de facture --}}
        <div class="card-footer">
            <a href="{{ route("paiements.facture", $commande->commande_id) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-pdf"></i> Télécharger la Facture
            </a>
        </div>
    @endif
</div>
@endsection
