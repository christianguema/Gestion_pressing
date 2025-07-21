@extends('layouts.base')

@section('title', 'Liste des Personnels')

@section('content')
    {{-- <div class="container">
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
    </div> --}}

    
@endsection
