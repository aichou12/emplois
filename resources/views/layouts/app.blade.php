<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGDE</title>
    <!-- Inclure le fichier CSS avec la méthode asset() -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

</head>
<body>
    @include('partials.site-header')

    <div class="container app-content">
        @yield('content') <!-- C'est ici que le contenu des vues sera injecté -->
    </div>
    @unless (request()->routeIs('admin.*'))
        @include('partials.user-footer')
    @endunless

<style>
    body { min-height:100vh; display:flex; flex-direction:column; }
    .app-content { flex:1 0 auto; width:100%; }
</style>

    <!-- Scripts (si nécessaire) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
