<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body>

<nav id="navbar-main" class="navbar-main navbar navbar-expand-lg fixed-top d-flex justify-content-between">
    <a class="navbar-brand" href="{{ route('index') }}">
        <div class="text-white">Вело</div>
        <div class="bright text-uppercase">hub</div>
    </a>
    <div>
        <div class="text-white px-5">
            @widget(header-contacts)
        </div>
    </div>
</nav>

<div id="content">
    @yield('content')
</div>

@include('partials.scripts')
</body>
</html>
