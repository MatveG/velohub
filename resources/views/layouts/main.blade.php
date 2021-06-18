<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.header')
    @include('includes.toolbar')

    <div id="content">
        @yield('content')
    </div>

    @include('includes.footer')
    @include('includes.scripts')
</body>
</html>
