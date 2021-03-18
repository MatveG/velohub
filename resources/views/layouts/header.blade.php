<nav id="navbar-main" class="navbar-main navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="{{ route('index') }}">
        <div class="text-white text-uppercase" style="font-size:150%;">вело</div>
        <div class="bright" style="font-size:144%;">hub</div>
    </a>

    <nav class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <ul class="navbar-nav px-3">
            @include('layouts.header.catalog')
        </ul>

        @include('layouts.header.buttons')
    </nav>

    @include('layouts.header.collapse')

    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
