<!-- Modern Accueil avec Top Bar adaptée - welcome.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Projet Pressing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/css/acceuil.css') }}">
</head>
<body>
  <div class="overlay"></div>
  <div class="topbar">
    @if (Route::has('login'))
        @auth
            <a href="{{ url('/dashboard') }}">
                Dashboard
            </a>
        @else
            {{-- <a href="{{ route('login') }}" class="btn-login">Se connecter</a> --}}
            {{-- @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>
            @endif --}}
        @endauth
    @endif
    <h1>Ges-press</h1>
    {{-- <a class="cta-btn" href="{{ route('register') }}">Inscription</a> --}}
  </div>
  <div class="container">
    <div class="card">
      <div class="logo">
        <!-- Icône SVG chemise/blanchisserie -->
        <svg viewBox="0 0 64 64" fill="none">
          <rect x="18" y="20" width="28" height="32" rx="6" fill="#2563eb"/>
          <path d="M32 12L18 20V52C18 55.3137 20.6863 58 24 58H42C45.3137 58 48 55.3137 48 52V20L32 12Z" fill="#60a5fa" stroke="#1e3a5c" stroke-width="2"/>
          <circle cx="32" cy="28" r="3" fill="#fff"/>
        </svg>
      </div>
      <h1>BIENVENUE</h1>
      <p>
        Gérez votre pressing de façon moderne : commandes, clients, statistiques, tout est là.<br>
        Simple, rapide, efficace.
      </p>
      @if(Route::has('login'))
        @auth
            <a href="{{ url('/dashboard') }}" class="btn">Accéder au Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn">Connexion</a>
            {{-- <a href="{{ route('register') }}" class="btn">S'inscrire</a> --}}
        @endauth
    @endif
    </div>
  </div>
</body>
</html>
