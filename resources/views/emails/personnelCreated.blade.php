<!DOCTYPE html>
<html>

<head>
    <title>Vos accès à la plateforme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="shadow card">
                    <div class="text-center text-white card-header bg-primary">
                        <h2 class="mb-0">Bienvenue sur la plateforme</h2>
                    </div>
                    <div class="card-body">
                        <p class="lead">Bonjour <strong>{{ $user->name }} {{ $user->last_name }}</strong>,</p>
                        <p>Voici vos identifiants de connexion :</p>
                        <ul class="mb-3 list-group">
                            <li class="list-group-item">
                                <strong>Email :</strong> {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                <strong>Mot de passe :</strong> {{ $password }}
                            </li>
                        </ul>
                        <div class="mb-3">
                            <a href="{{ url('/login') }}" class="btn btn-success">
                                Se connecter à la plateforme
                            </a>
                        </div>
                        <p class="mb-0 text-warning">
                            <small>Pensez à changer votre mot de passe après la première connexion pour plus de
                                sécurité.</small>
                        </p>
                    </div>
                    <div class="text-center card-footer text-muted">
                        Cordialement,<br>L'équipe
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
