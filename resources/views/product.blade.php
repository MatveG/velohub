@extends('layouts.main')

@section('content')
    @include('partials.product.toolbar')

    <main class="content">
        <div class="row">
            <section class="col-12 col-lg-9 col-xl-9">
                @include('partials.product.general')
            </section>
            <section class="col-12 col-lg-3 col-xl-3 text-center">
                @include('partials.product.tocart')
                @include('partials.product.info')
            </section>
        </div>

        <section id="product-description" class="mt-3">
            <h3><span>Описание</span></h3>
            {!! $product->text !!}
        </section>

        <section id="product-comments" class="mt-3 p-3 bg-light">
            <h3><span>Отзывы о {{ $product->model }}</span></h3>
            <ul class="media-list p-0">
                @include('partials.product.comments', ['comments' => $product->comments])
            </ul>

            <div class="text-center">
                <button class="btn btn-dark" role="button" data-toggle="modal" data-target="#modal-add-comment">
                    <span>Написать свой отзыв</span>
                </button>
            </div>
        </section>

        <section id="product-analogues" class="mt-3">
            <h3><span>Аналоги</span></h3>

            <div class="row w-100 text-center">
                @foreach($product->analogs->take(6) as $product)
                    @include('partials.product')
                @endforeach
            </div>
        </section>
    </main>

    @include('modals.image')

    @include('modals.comment')

    @if(count($errors))
        <script>$(() => { $('#modal-add-comment').modal() })</script>
    @endif
@endsection
