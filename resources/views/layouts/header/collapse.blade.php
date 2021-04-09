<div id="navbar-info" class="navbar-info">
    <div id="navbar-info-phone" class="row collapse navbar-info-block" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body">
            @widget(header-contacts)
        </div>
        <div class="col-1 align-self-center">
            <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#navbar-info-phone" />
        </div>
    </div>

    <div id="navbar-info-search" class="row collapse navbar-info-block" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body">
            @include('category.search')
        </div>
        <div class="col-1 align-self-center">
            <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#navbar-info-search" />
        </div>
    </div>

{{--    <div id="navbar-info-compare" class="row collapse navbar-info-block" data-parent="#navbar-info">--}}
{{--        <div class="col-1"></div>--}}
{{--        <div class="col-10 navbar-info-body">--}}

{{--        </div>--}}
{{--        <div class="col-1 align-self-center">--}}
{{--            <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#navbar-info-compare" />--}}
{{--        </div>--}}
{{--    </div>--}}

    <div id="navbar-info-notify" class="row collapse navbar-info-block bg-bright" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body"> </div>
        <div class="col-1 align-self-center">
            <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#navbar-info-notify" />
        </div>
    </div>
</div>
