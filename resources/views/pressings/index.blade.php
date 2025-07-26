@extends('layouts.base')
@section('title','Liste des pressings')

@section('content')
    <h1>Liste des Pressings</h1>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <a href="{{ route('pressings.create') }}" class="btn btn-primary mb-3">Ajouter un Pressing</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pressings as $pressing)
                <tr>
                    <td>{{ $pressing->nom }}</td>
                    <td>{{ $pressing->adresse }}</td>
                    <td>
                        <a href="{{ route('pressings.show', $pressing->pressing_id) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('pressings.edit', $pressing->pressing_id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('pressings.destroy', $pressing->pressing_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce pressing ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection