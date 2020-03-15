<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="{{ URL::asset('_admin/_assets/app.min.css') }}">
</head>
<body>
    <div id="app">
        <nav style="width: 12rem; height: 100%; position: fixed; left: 0;padding:1rem;background-color: #333;">
            <router-link to="/products">Товары</router-link><br><br>
            <router-link to="/categories">Категории</router-link><br><br>
        </nav>
        <router-view style="margin-left: 12rem;"></router-view>
    </div>

    <script src="{{ URL::asset('/_admin/_assets/app.min.js') }}"></script>
</body>
</html>
