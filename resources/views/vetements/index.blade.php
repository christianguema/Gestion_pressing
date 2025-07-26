@extends('layouts.base')

@section('title', 'Liste des Vêtements')

@section('content')
    <div class="container">
        <h1>Vêtements</h1>

        <a href="{{ route('vetements.create') }}" class="btn btn-success mb-3">Ajouter un Vêtement</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Pour la recherche --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('vetements.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="categorie_id" class="form-label">Filtrer par catégorie</label>
                        <select name="categorie_id" id="categorie_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->categorie_id }}" {{ request('categorie_id') == $cat->categorie_id ? 'selected' : '' }}>
                                    {{ $cat->intitule }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="search" class="form-label">Rechercher</label>
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Rechercher un vêtement..." value="{{ request('search') }}"
                            oninput="this.form.submit()">
                    </div>

                    @if(request()->hasAny(['categorie_id', 'search']))
                        <div class="col-md-4 d-flex align-items-end">
                            <a href="{{ route('vetements.index') }}" class="btn btn-outline-secondary">
                                Réinitialiser
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        @if($vetements->isEmpty())
            <p>Aucun vêtement enregistré.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Type</th>
                        <th>Prix Unitaire</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vetements as $vetement)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $vetement->type }}</td>
                            <td>{{ $vetement->prix_unitaire ?? 'Non défini' }}</td>
                            <td>{{ $vetement->categorie->intitule }}</td>
                            <td>
                                <a href="{{ route('vetements.show', $vetement) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('vetements.edit', $vetement) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('vetements.destroy', $vetement) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ce vêtement ?')">Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $vetements->links() }}
        @endif
    </div>
@endsection