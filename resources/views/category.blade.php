
@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="row">
            <aside class="col-md-2 pr-lg-3">
                <h2 class="d-none d-lg-block d-md-block"><span>Фильтр</span></h2>

                <button class="d-block d-lg-none d-md-none btn btn-light w-100 mb-3 text-center"
                        data-toggle="collapse" data-target="#collapse-filters">
                    Фильтр по параметрам
                </button>

                <div id="collapse-filters" class="collapse d-lg-block">
{{--                    @if(request()->filter)--}}
{{--                        <a class="btn btn-light w-100" href="{{$category->link}}">сбросить</a>--}}
{{--                    @endif--}}

                    @if(($filter = $filters->get('price')))
                        <div class="mt-2">
                            <strong>Цена</strong>
                            <div class="d-flex justify-content-between form-group">
                                <label for="prc_min">
                                    <input class="form-control shop-filter-input" name="price-min" value="{{ $filter->getValues()[0] }}">
                                </label>
                                <div class="p-2">до</div>
                                <label for="prc_min">
                                    <input class="form-control shop-filter-input" name="price-max" value="{{ $filter->getValues()[1] }}">
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
            </aside>

            <div class="col-md-10">
                @if(request()->route()->getActionMethod() === 'search')
                    <div class="text-center">
                        <div class="w-50 m-auto">@include('partials.category.search')</div>
                    </div>
                @else
                    <h2><span>{{ $meta->title }}</span></h2>
                @endif
                @if(count($products) == 0)
                    <main class="col-12 mt-3 text-center"><i>По данному запросу не найдено ни одного товара.</i></main>
                @else
                    @include('partials.category.toolbar')

                    <main class="mt-3 mb-3">
                        <div class="row text-center">
                            @include('partials.products')
                        </div>
                    </main>

                    @include('partials.category.toolbar')
                @endif
            </div>
        </div>
    </div>
@endsection
