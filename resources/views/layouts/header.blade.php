
<nav id="navbar-main" class="navbar-main navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="{{ route('index') }}">
        <div class="text-white text-uppercase" style="font-size:150%;">вело</div>
        <div class="bright" style="font-size:144%;">hub</div>
    </a>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            @widget('catalog')
        </ul>

        <div class="navbar-info-icons text-center">
            <button class="btn navbar-icon-btn icon-30 icon-phone" data-target="#navbar-info-phone" data-toggle="collapse"></button>
            <button class="btn navbar-icon-btn icon-30 icon-search" data-target="#navbar-info-search" data-toggle="collapse"></button>
            <button class="btn navbar-icon-btn icon-30 icon-compare" data-target="#navbar-info-compare" data-toggle="collapse"></button>
            <button id="cart-status" class="btn navbar-icon-btn icon-30 icon-cart-empty" data-target="#modal-cart" data-toggle="modal"></button>
        </div>
    </div>

    <div id="navbar-info" class="navbar-info">
        <div id="navbar-info-phone" class="row collapse navbar-info-block" data-parent="#navbar-info">
            <div class="col-1"></div>
            <div class="col-10 navbar-info-body">
                @widget('text', 'header-contacts')
            </div>
            <div class="col-1 align-self-center">
                <button class="btn close" data-toggle="collapse" data-target="#navbar-info-phone">&times;</button>
            </div>
        </div>

        <div id="navbar-info-search" class="row collapse navbar-info-block" data-parent="#navbar-info">
            <div class="col-1"></div>
            <div class="col-10 navbar-info-body">
                @include('includes.shop.search')
            </div>
            <div class="col-1 align-self-center">
                <button class="btn close" data-toggle="collapse" data-target="#navbar-info-search">&times;</button>
            </div>
        </div>

        <div id="navbar-info-compare" class="row collapse navbar-info-block" data-parent="#navbar-info">
            <div class="col-1"></div>
            <div class="col-10 navbar-info-body">
                @widget('compare')
            </div>
            <div class="col-1 align-self-center">
                <button class="btn close" data-toggle="collapse" data-target="#navbar-info-compare">&times;</button>
            </div>
        </div>

        <div id="navbar-info-notify" class="row collapse navbar-info-block bg-bright" data-parent="#navbar-info">
            <div class="col-1"></div>
            <div class="col-10 navbar-info-body"> </div>
            <div class="col-1 align-self-center">
                <button class="btn close" data-toggle="collapse" data-target="#navbar-info-notify">&times;</button>
            </div>
        </div>
    </div>

    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
