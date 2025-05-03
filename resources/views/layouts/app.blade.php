<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- Add this in the head section of your layout file -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Story Manager') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <div class="container-fluid">
            <div class="row">
                @auth
                    <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        @include('layouts.partials.sidebar')
                    </div>
                    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @else
                    <div class="col-12">
                @endauth
                        <main class="py-4">
                            @yield('content')
                        </main>
                    </div>
            </div>
        </div>

        @include('layouts.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
