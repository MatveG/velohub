<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.header')

    <div id="content">
        @yield('content')
    </div>

    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>
