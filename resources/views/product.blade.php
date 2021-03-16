@extends('layouts.main')

@section('content')
    @include('partials.product.toolbar')

    <main class="content">
        <div class="row">
            <section class="col-12 col-lg-9 col-xl-9">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-6">
                        @include('partials.product.general')
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6">
                        @include('partials.product.images')
                    </div>
                </div>
            </section>
            <section class="col-12 col-lg-3 col-xl-3 text-center">
                @include('partials.product.buy')

                @include('partials.product.terms')
            </section>
        </div>

        @if($product->text)
            <section id="product-description" class="mt-3">
                <h3><span>Описание</span></h3>
                {!! $product->text !!}
            </section>
        @endif

{{--        <section id="product-comments" class="mt-3 p-3 bg-light">--}}
{{--            <h3><span>Отзывы о {{ $product->model }}</span></h3>--}}
{{--            @include('partials.product.comments', ['comments' => $product->comments])--}}
{{--        </section>--}}

        <section id="product-analogues" class="mt-3">
            <h3><span>Аналоги</span></h3>
            <div class="row w-100 text-center">
                @foreach($product->analogs->take(6) as $product)
                    @include('partials.product')
                @endforeach
            </div>
        </section>
    </main>
@endsection
