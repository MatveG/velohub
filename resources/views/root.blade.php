@extends('layouts.main')

@section('content')
    <div class="block">
        <img class="w-100" src="{{ route('img.upload', ['img' => 'slider.jpg']) }}" alt="">
    </div>

    <main class="content">
        @if($saleProducts)
            <section>
                <h2><span>Скидки</span></h2>
                <div class="row text-center">
                    @foreach($saleProducts as $product)
                        @include('category.product')
                    @endforeach
                </div>
            </section>
        @endif

        <hr>

        @if($newProducts)
            <section>
                <h2><span>Новинки</span></h2>
                <div class="row text-center">
                    @foreach($newProducts as $product)
                        @include('category.product')
                    @endforeach
                </div>
            </section>
        @endif

        @if($document)
            <section class="container rounded">
                {{ $document->text }}
            </section>
        @endif
    </main>
@endsection
