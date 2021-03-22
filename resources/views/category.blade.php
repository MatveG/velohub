@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="row">
            <aside class="col-md-2 pr-lg-3">
                @include('partials.category.filters')
            </aside>

            <div class="col-md-10">
                <h2><span>{{ $meta->title }}</span></h2>

                @include('partials.category.toolbar')

                <main class="mt-3 mb-3">
                    <div class="row text-center">
                        @if(!$products)
                            <div class="col-12 text-center">
                                <i>По данному запросу не найдено ни одного товара.</i>
                            </div>
                        @endif

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
