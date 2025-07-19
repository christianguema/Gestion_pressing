@extends('layouts.loginBase')

@section('title', 'Réinitialiser le mot de passe')

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
<body class="p-0 app app-reset-password">
    <div class="row g-0 app-auth-wrapper">
	    <div class="p-5 text-center col-12 col-md-7 col-lg-6 auth-main-col">
		    <div class="d-flex flex-column align-content-end">
			    <div class="mx-auto app-auth-body">
				    <div class="mb-4 app-auth-branding">
                        <a class="app-logo" href="{{ url('/') }}">
                            <div class="logo-container">
                                <svg viewBox="0 0 64 64" fill="none">
                                    <rect x="18" y="20" width="28" height="32" rx="6" fill="#2563eb"/>
                                    <path d="M32 12L18 20V52C18 55.3137 20.6863 58 24 58H42C45.3137 58 48 55.3137 48 52V20L32 12Z" fill="#60a5fa" stroke="#1e3a5c" stroke-width="2"/>
                                    <circle cx="32" cy="28" r="3" fill="#fff"/>
                                </svg>
                            </div>
                        </a>
                    </div>
					<h2 class="mb-4 text-center auth-heading">Réinitialiser le mot de passe</h2>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
					<div class="mb-4 text-center auth-intro">Saisissez votre adresse e-mail ci-dessous. Nous vous enverrons par e-mail un lien vers une page où vous pourrez facilement créer un nouveau mot de passe.</div>

					<div class="text-left auth-form-container">

						<form class="auth-form resetpass-form" method="POST" action="{{ route('password.email') }}">
                            @csrf
							<div class="mb-3 email">
								<label class="sr-only" for="email" :value="__('Email')">Email</label>
								<input id="email" name="email type="email" class="form-control login-email" placeholder="Votre Email" :value="old('email')" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div><!--//form-group-->
							<div class="text-center">
								<button type="submit" class="mx-auto btn app-btn-primary btn-block theme-btn">Enregistrer</button>
							</div>
						</form>

						<div class="pt-5 text-center auth-option"><a class="app-link" href="{{ route('login') }}" >Se Connecter</a> <span class="px-2"></div>
					</div><!--//auth-form-container-->
			    </div><!--//auth-body-->
		    </div><!--//flex-column-->
	    </div><!--//auth-main-col-->

        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
		    <div class="auth-background-holder">
		    </div>
		    <div class="auth-background-mask"></div>
		    <div class="p-3 auth-background-overlay p-lg-5">
			    <div class="d-flex flex-column align-content-end h-100">
				    <div class="h-100"></div>
				    <div class="p-3 rounded overlay-content p-lg-4">
					    <h5 class="mb-3 overlay-title">Ges-press</h5>
					    <div>De plus en plus rapide et fiable</div>
				    </div>
				</div>
		    </div><!--//auth-background-overlay-->
	    </div><!--//auth-background-col-->

    </div>
</body>
@endsection

