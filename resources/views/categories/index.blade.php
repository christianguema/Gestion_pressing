@extends('layouts.base')

@section('title', 'Liste des Catégories')

@section('content')

<h1>Categories</h1>

<a href="{{ route('categories.create') }}" class="mb-3 btn btn-success">Ajouter une Catégorie</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($categories->isEmpty())
<p>Aucune catégorie enregistrée.</p>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Numero</th>
            <th>Intitulé</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $categorie)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{ $categorie->intitule }}</td>
            <td>
                <a href="{{ route('categories.show', $categorie) }}" class="btn btn-sm btn-info">Voir</a>
                <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-sm btn-warning">Modifier</a>
                <form action="{{ route('categories.destroy', $categorie) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Supprimer cette catégorie ?')">Supprimer
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif

@endsection
