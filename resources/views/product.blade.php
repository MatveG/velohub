@extends('layouts.main')

@section('content')
    @include('product.toolbar')

    <main class="content">
        <div class="row">
            <section class="col-12 col-lg-9 col-xl-9">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-6">
                        @include('product.general')
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div id="product-image">
                            <script>
                                window._PRODUCT_IMAGES = {!!json_encode($product->images)!!};
                            </script>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-12 col-lg-3 col-xl-3 text-center">
                <div class="m-auto">
                    <h4><span>Купить</span></h4>

                    <div id="product-buy">
                        <script>
                            window._PRODUCT = {!!json_encode($product->only(['id', 'is_stock', 'is_sale', 'price', 'price_sale']))!!};
                            window._PRODUCT_VARIANTS = {!!$product->variants!!};
                        </script>
                    </div>
                </div>

                @include('product.terms')
            </section>
        </div>

        @if($product->text)
            <section id="product-description" class="mt-3">
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
