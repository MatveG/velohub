
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
                    @if($filters->active)
                        <a class="btn btn-light w-100" href="{{ $filters->base }}">сбросить</a>
                    @endif
                    @if(isset($filters->prices) &&
                        (array_key_first($filters->prices->min->values) ||
                        array_key_first($filters->prices->max->values)) )
                        <div class="mt-2">
                            <strong>Цена</strong>
                            <div class="row form-group">
                                <div class="col-5 pr-0">
                                    <label for="prc_min">
                                        <input class="form-control shop-filter-input" name="price-min" value="{{ array_key_first($filters->prices->min->values) }}">
                                    </label>
                                </div>
                                <div class="col-2 p-2 m-0">до</div>
                                <div class="col-5 pl-0">
                                    <label for="prc_min">
                                        <input class="form-control shop-filter-input" name="price-max" value="{{ array_key_first($filters->prices->max->values) }}">
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($filters->brands))
                        @foreach($filters->brands as $name => $filter)
                            @include('partials.category.filter')
                        @endforeach
                    @endif

                    @if(isset($filters->features))
                        @foreach($filters->features as $name => $filter)
                            @include('partials.category.filter')
                        @endforeach
                    @endif

                    @if(isset($filters->options))
                        @foreach($filters->options as $name => $filter)
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
