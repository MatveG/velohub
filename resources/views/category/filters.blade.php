<h2 class="d-none d-lg-block d-md-block">
    <span>Параметры</span>
</h2>

<button class="d-block d-lg-none d-md-none btn btn-light w-100 mb-3 text-center"
        data-bs-toggle="collapse"
        data-bs-target="#collapse-filters">
    Фильтр по параметрам
</button>

<div id="collapse-filters" class="collapse d-lg-block">
    @if(request()->filter)
        <a class="btn btn-light w-100" href="{{$category->link}}">сбросить</a>
    @endif

    @include('category.sort')

    @foreach($filters as $filter)
        <div class="mt-2">
        @if($filter->type === 'slider')
            @include('category.filters.slider')
        @else
            <span class="fw-bold">{{ $filter->title }}</span>
            @include('category.filters.plain')
        @endif
        </div>
    @endforeach
</div>
