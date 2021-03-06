<div id="navbar-info" class="navbar-info">
    <div id="navbar-info-phone" class="row collapse navbar-info-block" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body">
            @widget(header-contacts)
        </div>
        <div class="col-1 align-self-center">
            <button class="btn close" data-toggle="collapse" data-target="#navbar-info-phone">&times;</button>
        </div>
    </div>

    <div id="navbar-info-search" class="row collapse navbar-info-block" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body">
            @include('partials.category.search')
        </div>
        <div class="col-1 align-self-center">
            <button class="btn close" data-toggle="collapse" data-target="#navbar-info-search">&times;</button>
        </div>
    </div>

    <div id="navbar-info-compare" class="row collapse navbar-info-block" data-parent="#navbar-info">
        <div class="col-1"></div>
        <div class="col-10 navbar-info-body">
            {{--                @widget('compare')--}}
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
