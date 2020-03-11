<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::layouts.head')
</head>
<body>

<div id="app">
    @include('admin::layouts.navbar')
    <!-- Page content -->
    <div id="page-content-wrapper" style="margin-left: 12rem;">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::asset('/admin/assets/app.min.js') }}"></script>

</body>
</html>
