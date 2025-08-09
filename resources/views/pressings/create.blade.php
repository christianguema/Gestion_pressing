@extends('layouts.base')
@section('title','Enregistrer un pressing')

@section('content')

<div class="pagetitle">
    <h1>PRESSINGS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pressings.index') }}">Pressings</a></li>
             <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>
</div>

{{-- <h1>Ajouter un Pressing</h1> --}}
<form action="{{ route('pressings.store') }}" method="POST">
    @csrf
    @include('pressings._form')
    <br>
    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>
@endsection
