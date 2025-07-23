@extends('layouts.base')
@section('title', 'Types de Prestation')

@section('content')
    <div class="container">
        <h1>Types de Prestation</h1>

        <a href="{{ route('type_prestations.create') }}" class="btn btn-success mb-3">Ajouter un Type</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($typePrestations->isEmpty())
            <p>Aucun type de prestation enregistré.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        
                        <th>Intitulé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($typePrestations as $prestation)
                        <tr>
                            
                            <td>{{ $prestation->intitule }}</td>
                            <td>
                                <a href="{{ route('type_prestations.show', $prestation) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('type_prestations.edit', $prestation) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('type_prestations.destroy', $prestation) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ce type de prestation ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $typePrestations->links() }} <!-- Pagination -->
        @endif
    </div>
@endsection