<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Acceuil Elements -->
    <link href="{{ asset('/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- FontAwesome JS-->
    <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <!-- App CSS -->

    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
    <title>@yield('title', 'Titre par défaut')</title>
</head>
<body>
    <div class="row g-0 app-auth-wrapper">
        @yield('content')
    </div>
</body>
</html>
