@extends('layouts.base')
@section('title','Type Facturation')

@section('content')
    <h1>Gestion des Types de Facturation</h1>

    <a href="{{ route('type_facturations.create') }}" class="btn btn-primary">Ajouter un Type de Facturation</a>

    <table class="table">
        <thead>
            <tr>
                
                <th>Libellé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($typeFacturations as $typeFacturation)
                <tr>
                    
                    <td>{{ $typeFacturation->libelle }}</td>
                    <td>
                        <a href="{{ route('type_facturations.edit', $typeFacturation) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('type_facturations.destroy', $typeFacturation) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection