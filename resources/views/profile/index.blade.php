@extends('layouts.base')

@section('title', 'Profile')

@section('content')
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Utilisateurs</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    @auth
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="pt-4 card-body profile-card d-flex flex-column align-items-center">
                    <?php
                            $prenom = auth()->user()->last_name;
                            $nom = auth()->user()->name;
                            $contact = auth()->user()->contact;
                            $profession = auth()->user()->profession;
                            $email = auth()->user()->email;

                            ?>
                    <img src="{{ $user->profilImage ? asset('storage/' . $user->profilImage) : asset('assets/img/profile-img.jpg') }}" alt="Profile" style="width:120px; height:120px; object-fit:cover;" class="mb-3 img-fluid rounded-circle">
                    <h2>{{ ucfirst($nom) }} {{ ucfirst($prenom) }}</h2>
                    @if (auth()->user()->profession)
                        <h3>{{ auth()->user()->profession }}</h3>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="pt-3 card-body">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Apercu</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editer
                                Profile</button>
                        </li>

                        @role('gestionnaire')
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Supprimer
                                Compte</button>
                        </li>
                        @endrole

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Changer Mot de Passe</button>
                        </li>
                    </ul>
                    <div class="pt-2 tab-content">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Profile Infos</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nom Complet</div>
                                <div class="col-lg-9 col-md-8">{{ ucfirst($nom) }} {{ ucfirst($prenom) }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Contact</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->contact }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Profession</div>
                                @if (auth()->user()->profession)
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->profession }}</div>
                                @else
                                <div class="col-lg-9 col-md-8">Pas specifier</div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                            </div>

                        </div>

                        <div class="pt-3 tab-pane fade profile-edit" id="profile-edit">
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <!-- Profile Edit Form -->
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="mb-3 row">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img id="profilePreview"
                                            src="{{ $user->profilImage ? asset('storage/' . $user->profilImage) : asset('assets/img/profile-img.jpg') }}"
                                            alt="Profile">
                                        <div class="pt-2">
                                            <a href="#" class="btn btn-primary btn-sm" title="Changer la photo"
                                                id="uploadButton"><i class="bi bi-upload"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm" title="Supprimer la photo"
                                                id="deleteButton"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                    <input type="file" id="profileImageInput" name="profileImage" class="d-none">
                                </div>

                                <script>
                                    document.getElementById('uploadButton').addEventListener('click', function(e) {
                                                e.preventDefault();
                                                document.getElementById('profileImageInput').click();
                                            });

                                            document.getElementById('profileImageInput').addEventListener('change', function() {
                                                const file = this.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        document.getElementById('profilePreview').setAttribute('src', e.target.result);
                                                    }
                                                    reader.readAsDataURL(file);
                                                }
                                            });

                                            document.getElementById('deleteButton').addEventListener('click', function(e) {
                                                e.preventDefault();

                                                if (confirm('Êtes-vous sûr de vouloir supprimer la photo de profil ?')) {
                                                    // Envoyer une requête pour supprimer la photo
                                                    fetch('{{ route('profil.deleteImage') }}', {
                                                            method: 'DELETE',
                                                            headers: {
                                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                                    'content'),
                                                                'Content-Type': 'application/json'
                                                            },
                                                        }).then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                document.getElementById('profilePreview').setAttribute('src',
                                                                    '{{ asset('assets/img/default-profile.jpg') }}');
                                                            }
                                                        });
                                                }
                                            });
                                </script>

                                <div class="mb-3 row">
                                    <label for="name" :value="__('Name')"
                                        class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="name"
                                            value="{{ old('name', $nom) }}" required autofocus autocomplete="name">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="lastname" type="text" class="form-control" id="lastname"
                                            value="{{ old('lastname', $prenom) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="profession" class="col-md-4 col-lg-3 col-form-label">Profession</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="profession" type="text" class="form-control" id="Job"
                                            value="{{ old('profession', $profession) }}" placeholder="rien">
                                    </div>
                                </div>


                                <div class="mb-3 row">
                                    <label for="contact" class="col-md-4 col-lg-3 col-form-label">Contact</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="contact" type="text" class="form-control" id="Phone"
                                            value="{{ old('contact', $contact) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{ old('email', $email) }}" placeholder="Rien">
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>

                        <div class="pt-3 tab-pane fade" id="profile-settings">
                            <!-- Settings Form -->
                            <div class="mb-3 row">
                                <p>Une fois votre compte supprimé, toutes ses ressources et données seront
                                    définitivement supprimées.</p>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteAccountModal">Supprimer</button>
                            </div>

                            <!-- Modal de confirmation pour la suppression du compte -->
                            <form action="{{ route('profile.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal fade" id="deleteAccountModal" tabindex="-1"
                                    aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteAccountModalLabel">Confirmer la
                                                    suppression du compte</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est
                                                    irréversible.</p>
                                                <div class="text-center">
                                                    <label for="password" class="col-md-4 col-lg-3 col-form-label">Mot
                                                        de Passe</label>
                                                    <input type="password" id="password" name="password"
                                                        class="form-control">
                                                    @if ($errors->has('password'))
                                                    <div class="mt-2 text-danger">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger"
                                                    id="confirmDeleteBtn">Confirmer la suppression</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form><!-- End settings Form -->
                        </div>

                        <div class="pt-3 tab-pane fade" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')
                                <div class="mb-3 row">
                                    <label for="update_password_current_password"
                                        class="col-md-4 col-lg-3 col-form-label">Mot de Passe Actuel</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input id="update_password_current_password" name="current_password"
                                            type="password" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="update_password_password"
                                        class="col-md-4 col-lg-3 col-form-label">Nouveau Mot de Passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control"
                                            id="update_password_password">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="update_password_password_confirmation"
                                        class="col-md-4 col-lg-3 col-form-label">Confirmer Mot de Passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password_confirmation" type="password" class="form-control"
                                            id="update_password_password_confirmation">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form><!-- End Change Password Form -->
                        </div>

                    </div><!-- End Bordered Tabs -->
                </div>
            </div>

        </div>
    </div>
    @endauth
</section>

@endsection
