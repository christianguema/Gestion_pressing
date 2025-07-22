@extends('layouts.base')


@section('title', 'Commandes')

@section('content')

@if (session('success'))
    @include('components.alertModals.success')
@endif

@if (session('error'))
    @include('components.alertModals.error')
@endif

<div class="pagetitle">
    <h1>LISTE DES COMMANDES EN ATTENTES</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('commandes.index') }}">Commandes</a></li>
            <li class="breadcrumb-item active">Attentes</li>
        </ol>
    </nav>
</div>



@endsection
