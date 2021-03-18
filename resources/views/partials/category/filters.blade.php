<h2 class="d-none d-lg-block d-md-block"><span>Фильтр</span></h2>

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

    @endforeach
    @if($filter && $filter->values)
        <div class="mt-2">
            <strong>Цена</strong>
            <div class="d-flex justify-content-between form-group">
                <label for="prc_min">
                    <input class="form-control category-filter" name="price" value="{{$filter->values[0]}}">
                </label>
                <div class="p-2">до</div>
                <label for="prc_min">
                    <input class="form-control category-filter" name="price" value="{{$filter->values[1]}}">
                </label>
            </div>
        </div>
    @endif

    @if(($filter = $filters->get('brand')))
        <b>{{ $filter->title }}</b>
        @include('partials.category.filter')
    @endif

    @if($filters->has('features'))
        @foreach($filters->get('features')->filters as $name => $filter)
            <b>{{ $filter->title }}</b>
            @include('partials.category.filter')
        @endforeach
    @endif

    @if($filters->has('properties'))
        @foreach($filters->get('properties')->filters as $name => $filter)
            <b>{{ $filter->title }}</b>
            @include('partials.category.filter')
        @endforeach
    @endif
</div>
