<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{--    <meta name="csrf-token" content="{{ csrf_token() }}" />--}}

    <link rel="stylesheet" href="{{ URL::asset('/assets/admin/bulma.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/admin/buefy.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/admin/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/admin/app.min.css') }}">
</head>
<body>
    <div id="app">
        <nav style="width: 12rem; height: 100%; position: fixed; left: 0;padding:1rem;background-color: #333;">
            <router-link to="/product">Товары</router-link><br><br>
            <router-link to="/category">Категории</router-link><br><br>
        </nav>
        <router-view style="margin-left: 12rem;"></router-view>
    </div>

    <script src="{{ URL::asset('/assets/admin/app.min.js') }}"></script>
</body>
</html>
