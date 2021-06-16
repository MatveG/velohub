@extends('layouts.main')

@section('path')
    <li class="nav-item">
        <div class="nav-link px-0 fw-bold">&#8250;</div>
    </li>
    <li class="nav-item">
        <a href="{{ $product->category->link }}" class="nav-link">
            {{ $product->category->title }}
        </a>
    </li>
    <li class="nav-item px-0">
        <div class="nav-link px-0 fw-bold">&#8250;</div>
    </li>
    <li class="nav-item">
            <span class="nav-link">
                {{$product->model}}
            </span>
    </li>
@endsection

@section('content')
    <main class="content">
        <h1><span>{{ $product->name }} {{$product->model}}</span></h1>

        <div class="row mt-4">
            <section class="col-12 col-lg-10 col-xl-10" id="product-description">
                <div class="row">
                    <div class="col-12 col-lg-7 col-xl-7">
                        @include('product.general')
                        {{--        <div class="text-right">--}}
                        {{--            <button class="btn btn-sm btn-light compare-toggle" role="button">--}}
                        {{--                в сравнение--}}
                        {{--            </button>--}}
                        {{--        </div>--}}
                    </div>

                    <div class="col-12 col-lg-5 col-xl-5">
                        <div id="product-image">
                            <script>
                                window._PRODUCT_IMAGES = {!!json_encode($product->images)!!};
                                window._PRODUCT_IMAGES_PATH = '{!!Storage::url('')!!}';
                            </script>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-12 col-lg-2 col-xl-2 text-center">
                <div class="m-auto py-3 rounded-3 shadow-sm">
                    <h5><span>Купить</span></h5>
                    <div id="product-buy">
                        <script>
                            window._PRODUCT = {!!json_encode($product->only(['id', 'is_stock', 'is_sale', 'price', 'price_old']))!!};
                            window._PRODUCT_VARIANTS = {!!$product->variants!!};
                        </script>
                    </div>
                </div>

                <div class="mt-3 px-3 py-2 rounded-3 shadow-sm">
                    @include('product.terms')
                </div>
            </section>
        </div>

        @if($product->text)
            <section class="mt-3">
                <h3><span>Описание</span></h3>
                {!! $product->text !!}
            </section>
        @endif

{{--        @if($product->comments)--}}
{{--        <section id="Product-comments" class="mt-3 p-3 bg-light">--}}
{{--            <h3><span>Отзывы о {{ $Product->model }}</span></h3>--}}
{{--            @include('partials.Product.comments', ['comments' => $Product->comments])--}}
{{--        </section>--}}
{{--        @endif--}}

        <section id="product-analogues" class="mt-3">
            <h3><span>Аналоги</span></h3>
            <div class="row w-100 text-center">
                @foreach($product->analogs->take(6) as $product)
                    @include('category.product')
                @endforeach
            </div>
        </section>
    </main>
@endsection
