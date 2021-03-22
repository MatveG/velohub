<h2 class="d-none d-lg-block d-md-block">
    <span>Фильтр</span>
</h2>

<button class="d-block d-lg-none d-md-none btn btn-light w-100 mb-3 text-center"
        data-toggle="collapse"
        data-target="#collapse-filters">
    Фильтр по параметрам
</button>

<div id="collapse-filters" class="collapse d-lg-block">
    @if(request()->filter)
        <a class="btn btn-light w-100" href="{{$category->link}}">сбросить</a>
    @endif

    @foreach($filters as $filter)
        <div class="mt-2">
        @if($filter->type === 'slider')
            @include('partials.category.filters.slider')
        @else
            <span class="fw-bold">{{ $filter->title }}</span>
            @include('partials.category.filters.plain')
        @endif
        </div>
    @endforeach
</div>
