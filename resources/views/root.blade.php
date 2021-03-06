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
                    @include('partials.products', ['products' => $saleProducts])
                </div>
            </section>
        @endif

        <hr>

        @if($newProducts)
            <section>
                <h2><span>Новинки</span></h2>
                <div class="row text-center">
                    @include('partials.products', ['products' => $newProducts])
                </div>
            </section>
        @endif

        @if($content)
            <section class="container rounded">
                {{ $content->text }}
            </section>
        @endif
    </main>
@endsection
