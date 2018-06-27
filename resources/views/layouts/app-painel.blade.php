<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script>
        window.Laravel = {!! json_encode([
            'token' => csrf_token()
        ]) !!};
        </script>

    </head>
    <body>

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top">
            @include('includs.nav')
        </nav>

        <main id="app" class="py-4">
            @yield('content')
        </main>

        <footer class="footer border-top fixed-bottom d-print-none bg-white">
            <div class="container text-center">
                <span class="text-secondary"> © {{ config('app.name') }} - gerenciador de serviços</span>
            </div>
        </footer>

        @component('layouts.default.scripts-painel')
            @yield('scripts-painel')
        @endcomponent

    </body>
</html>
