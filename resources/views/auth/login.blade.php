@extends('layouts.loginBase')

@section('title', 'Connexion')

@section('content')
<style>
    .logo-container {
        width: 80px;
        height: 80px;
        margin-bottom: 1.5rem;
        border-radius: 50%;
        background: #60a5fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 2px 12px #2563eb33;
    }

    .logo-container svg {
        width: 48px;
        height: 48px;
        display: block;
    }
</style>

<body class="p-0 app app-login">
    <div class="p-5 text-center col-12 col-md-7 col-lg-6 auth-main-col">
        <div class="d-flex flex-column align-content-end">
            <div class="mx-auto app-auth-body">
                <div class="mb-4 app-auth-branding">
                    <a class="app-logo" href="{{ url('/') }}">
                        <div class="logo-container">
                            <svg viewBox="0 0 64 64" fill="none">
                                <rect x="18" y="20" width="28" height="32" rx="6" fill="#2563eb" />
                                <path
                                    d="M32 12L18 20V52C18 55.3137 20.6863 58 24 58H42C45.3137 58 48 55.3137 48 52V20L32 12Z"
                                    fill="#60a5fa" stroke="#1e3a5c" stroke-width="2" />
                                <circle cx="32" cy="28" r="3" fill="#fff" />
                            </svg>
                        </div>
                    </a>
                </div>

                <h2 class="mb-5 text-center auth-heading">Se connecter</h2>
                <div class="auth-form-container text-start">
                    <form class="auth-form login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3 email">
                            <label class="sr-only" for="email" :value="__('Email')">Email</label>
                            <input id="signin-email" name="email" type="email" class="form-control signin-email"
                                placeholder="Adresse Email" :value="old('email')" required autofocus
                                autocomplete="username">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--//form-group-->
                        <div class="mb-3 password">
                            <label class="sr-only" for="password" :value="__('Password')">Mot de passe</label>
                            <input id="password" name="password" type="password" class="form-control signin-password" placeholder="mot de passe" requiredautocomplete="current-password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mt-3 extra row justify-content-between">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="remember"
                                            id="RememberPassword">
                                        <label class="form-check-label" for="RememberPassword">
                                            Se souvenir de moi
                                        </label>
                                    </div>
                                </div>
                                <!--//col-6-->
                                <div class="col-6">
                                    <div class="forgot-password text-end">
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">Mot de passe oublié?</a>
                                        @endif
                                    </div>
                                </div>
                                <!--//col-6-->
                            </div>
                            <!--//extra-->
                        </div>
                        <!--//form-group-->
                        <div class="text-center">
                            <button type="submit" class="mx-auto btn app-btn-primary w-100 theme-btn">Connexion</button>
                        </div>
                    </form>
                </div>
                <!--//auth-form-container-->

            </div>
            <!--//auth-body-->
        </div>
        <!--//flex-column-->
    </div>
    <!--//auth-main-col-->

    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder">
        </div>
        <div class="auth-background-mask"></div>
        <div class="p-3 auth-background-overlay p-lg-5">
            <div class="d-flex flex-column align-content-end h-100">
                <div class="h-100"></div>
                <div class="p-3 rounded overlay-content p-lg-4">
                    <h5 class="mb-3 overlay-title">Bienvenu sur le page de connexion</h5>
                    <div>
                        Plus rapide et fiable que jamais, Ges-press vous permet de gérer votre pressing en toute simplicité.
                        <br>
                        Connectez-vous pour accéder à votre tableau de bord et découvrir toutes les fonctionnalités.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


@endsection
