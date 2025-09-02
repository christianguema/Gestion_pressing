@extends('layouts.base')

@section('title','Gestion des comptes')

@section('content')

@if(session('success'))
@include('components.alertModals.success')
@endif

@if(session('error'))
@include('components.alertModals.error')
@endif


<div class="pagetitle">
    <h1>GESTION DES COMPTES</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Comptes</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Liste des comptes personnel</h5>

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom complet</th>
                                <th>Poste</th>
                                <th>Pressing</th>
                                <th>Contact</th>
                                {{-- <th>Statut</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personnels as $personnel)
                            <tr>
                                <td>
                                    <img src="{{ $personnel->user->profilImage ?
                                        asset('storage/'.$personnel->user->profilImage) :
                                        asset('assets/img/profile-img.jpg') }}"
                                        alt="Profile" class="rounded-circle" width="40">
                                </td>
                                <td>{{ $personnel->user->name }} {{ $personnel->user->last_name }}</td>
                                <td>{{ $personnel->poste }}</td>
                                <td>{{ $personnel->pressing->nom }}</td>
                                <td>{{ $personnel->user->contact }}</td>
                                {{-- <td>
                                    <span class="badge bg-{{ $personnel->status === 'actif' ? 'success' : 'danger' }}">
                                        {{ $personnel->status }}
                                    </span>
                                </td> --}}
                                <td>
                                    @can('manage-accounts')
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal{{ $personnel->personnel_id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#rolesModal{{ $personnel->personnel_id }}">
                                                <i class="bi bi-shield-lock"></i>
                                            </button>
                                        </div>
                                    @endcan
                                </td>
                            </tr>

                            {{-- Modal de modification --}}

                            <div class="modal fade" id="updateModal{{ $personnel->personnel_id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier le compte</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('personnels.updateAccount', $personnel) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Poste</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           name="poste"
                                                           value="{{ $personnel->poste }}"
                                                           required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Statut</label>
                                                    <select class="form-select" name="status" required>
                                                        <option value="actif" {{ $personnel->status === 'actif' ? 'selected' : '' }}>
                                                            Actif
                                                        </option>
                                                        <option value="inactif" {{ $personnel->status === 'inactif' ? 'selected' : '' }}>
                                                            Inactif
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Fermer
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Sauvegarder
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="rolesModal{{ $personnel->personnel_id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Gérer les rôles et permissions</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('personnels.updateRoles', $personnel) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                {{-- Rôles --}}
                                                <div class="mb-4">
                                                    <h6>Rôles</h6>
                                                    <div class="row g-3">
                                                        @foreach($roles as $role)
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="roles[]"
                                                                    value="{{ $role->name }}" id="role{{ $personnel->personnel_id }}{{ $role->id }}"
                                                                    {{ $personnel->user->hasRole($role) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="role{{ $personnel->personnel_id }}{{ $role->id }}">
                                                                    {{ ucfirst($role->name) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                {{-- Permissions --}}
                                                <div>
                                                    <h6>Permissions</h6>
                                                    <div class="row g-3">
                                                        @foreach($permissions as $permission)
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                                    value="{{ $permission->name }}"
                                                                    id="perm{{ $personnel->personnel_id }}{{ $permission->id }}" {{
                                                                    $personnel->user->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="perm{{ $personnel->personnel_id }}{{ $permission->id }}">
                                                                    {{ ucfirst($permission->name) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
