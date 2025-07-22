{{-- @extends('layouts.base')

@section('title', 'Liste des Personnels')

@section('content')
    <div class="container">
        <h1>Liste des Personnels</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personnels as $personnel)
                    <tr>
                        <td>{{ $personnel->id }}</td>
                        <td>{{ $personnel->name }}</td>
                        <td>{{ $personnel->email }}</td>
                        <td>{{ $personnel->position }}</td>
                        <td>
                            <a href="{{ route('personnels.show', $personnel->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('personnels.edit', $personnel->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('personnels.destroy', $personnel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $personnels->links() }}
    </div>

    
@endsection --}}

<!-- resources/views/personnels/index.blade.php -->

@extends('layouts.base')

@section('title', 'Liste des Personnels')
@section('content')

    <div class="pagetitle">
        <h1>PERSONNELS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Personnels</li>
            </ol>
        </nav>
    </div>

    {{-- <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                Liste des personnels
                <a href="{{ route('personnels.create') }}" class="btn btn-primary float-end">Ajouter</a>
            </h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Poste</th>
                        <th>Pressing</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($personnels as $p)
                        <tr>
                            <td>{{ $p->user->name }} {{ $p->user->lastname }}</td>
                            <td>{{ $p->user->email }}</td>
                            <td>{{ $p->poste }}</td>
                            <td>{{ $p->pressing?->nom ?? 'Non assigné' }}</td>
                            <td>
                                <!-- À compléter plus tard -->
                                <button class="btn btn-sm btn-secondary" disabled>Modifier</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

@endsection
