@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="row">
            <aside class="col-md-2 pr-lg-3">
                @if(is_countable($filters) && count($filters))
                    @include('partials.category.filters')
                @endif
            </aside>

            <div class="col-md-10">
                <h2><span>{{ $meta->title }}</span></h2>

                @include('partials.category.toolbar')

                @if(!$products)
                    <main class="col-12 mt-3 text-center">
                        <i>По данному запросу не найдено ни одного товара.</i>
                    </main>
                @endif

                <main class="mt-3 mb-3">
                    <div class="row text-center">
                        @foreach($products as $product)
                            @include('partials.product')
                        @endforeach
                    </div>
                </main>

                @include('partials.category.toolbar')
            </div>
        </div>
    </div>
@endsection
