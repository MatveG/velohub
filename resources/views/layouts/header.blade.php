<nav id="navbar-main" class="navbar-main navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="{{ route('index') }}">
        <div class="text-white">Вело</div>
        <div class="bright text-uppercase">hub</div>
    </a>

    <nav class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <ul class="navbar-nav px-3">
            @include('layouts.header.catalog-parent')
        </ul>

        <hr class="d-lg-none">

        <ul class="navbar-nav px-3 d-lg-none">
            @if($menuTree)
                @include('layouts.header.menu')
            @endif
        </ul>

        @include('layouts.header.right')

        <br class="d-lg-none">
    </nav>

    <button
        class="navbar-toggler navbar-dark"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
