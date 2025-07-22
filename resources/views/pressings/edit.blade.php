@extends('layouts.base')
@section('title','Modifier un pressing')

@section('content')
    <h1>Modifier le Pressing</h1>
    <form action="{{ route('pressings.update', $pressing->pressing_id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('pressings._form')
        <br>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection