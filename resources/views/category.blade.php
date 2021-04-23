@extends('layouts.main')

@section('content')
    @include('category.toolbar')

    <div class="content">
        <div class="row">
            <aside class="col-md-2 pr-lg-3">
                @include('category.filters')
            </aside>

            <div class="col-md-10">
                <h2><span>{{ $meta->title }}</span></h2>

                <main class="mt-3 mb-3">
                    <div class="row text-center">
                        @if(!$products)
                            <div class="col-12 text-center">
                                <i>По данному запросу не найдено ни одного товара.</i>
                            </div>
                        @endif

                        @foreach($products as $product)
                            @include('category.product')
                        @endforeach
                    </div>

                    <div class="pagination-lg flex-wrap my-4">
                        {{ $products->appends(request()->query())->onEachSide(1)->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
