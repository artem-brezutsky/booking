<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Админ панель</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.min.css') }}">
</head>

<body>
{{-- Main Admin Content --}}
<div id="app" class="admin-section">
    {{-- Nav-bar --}}
    @section('nav-bar')
        <div class="top-line">
            <nav class="admin-bar">
                <div class="left-side">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('img/abmeetings-logo.png') }}" alt="">
                    </a>
                </div>
                <div class="right-side">
                    <div class="user-title">{{ Auth::user()->name }}</div>
                    <div class="admin-logout-button">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        {{-- @endsection--}}
    @show

    <main class="admin-content">
        {{-- Left menu --}}
        @include('admin.layouts.menu')
        @yield('content')
    </main>
</div>
<footer>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"
            integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P"
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('assets/toastr/js/toastr.min.js') }}"></script>

</footer>
</body>
</html>
