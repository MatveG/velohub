<div class="text-center px-3" id="info-btn-group">
    <div class="dropstart d-none d-lg-inline-block mx-2">
        <button class="btn navbar-icon-btn icon-30 icon-search" type="button" data-bs-toggle="dropdown"></button>

        <div class="dropdown-menu p-2 input-search-cont">
            <form class="form m-auto" method="get" action="{{ route('search') }}">
                <div class="input-group input-search">
                    <input class="form-control rounded-1" type="search" name="find"
                           placeholder="Поиск товаров" value="{{ request('find') }}" required>
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-sm btn-bright icon-search">&nbsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <button
        class="btn navbar-icon-btn icon-30 icon-search d-lg-none"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#searchCollapse"></button>

{{--    <button class="btn navbar-icon-btn icon-30 icon-compare mx-2" data-bs-parent="#navbar-info"--}}
{{--            data-bs-target="#navbar-info-compare" data-bs-toggle="collapse"></button>--}}

    <button id="cart-status" class="btn navbar-icon-btn icon-30 icon-cart-empty mx-2"></button>

    <div class="collapse p-2" id="searchCollapse">
        <form class="form m-auto" method="get" action="{{ route('search') }}">
            <div class="input-group input-search">
                <input class="form-control rounded-1" type="search" name="find"
                       placeholder="Поиск товаров" value="{{ request('find') }}" required>
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-sm btn-bright icon-search">&nbsp;</button>
                </div>
            </div>
        </form>
    </div>
</div>
