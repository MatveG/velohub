
@extends('layouts.master')

@section('content')
    @include('includes.product.toolbar')

    <main class="content">
        <div class="row">
            <!-- MAIN -->
            <div class="col-12 col-lg-9 col-xl-9">
                <div class="row">
                    <!-- LEFT col -->
                    <div class="col-12 col-lg-6 col-xl-6">
                        <h1><span>{{ $product->name }} {{$product->model}}</span></h1>
                        <!-- codes -->
                        <div class="spacer"></div>
                        <p>
                            Код товара: <i>{{ $product->id }}</i><br>
                            Производитель: <i>{{ $product->brand }}</i><br>
                            Наименование: <i>{{ $product->model }}</i><br>
                            @if(!empty($product->features->year))
                                Год выпуска: <i>{{ $product->features->year }}</i><br>
                            @endif
                        </p>
                        <div class="spacer"></div>
                        <!-- previews -->
                        <p>{{ $product->preview }}</p>
                        <!-- features -->
                        @if($product->category->features)
                            <div class="spacer"></div>
                            @foreach($product->category->features as $key => $feature)
                                <span>{{ $feature->title }}: <i>{{ $product->features->{$key} }} {{ $feature->units }}</i></span><br>
                            @endforeach
                        @endif
                    </div>
                    <!-- /LEFT -->

                    <!-- MIDDLE col -->
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div class="text-right">
                            <button class="btn btn-sm btn-light compare-toggle" role="button" data-id="{{ $product->id }}">
                                сравнить
                            </button>
                        </div>
                        @if(count($product->images))
                            <div class="product-image">
                                <img class="main-image" role="button" data-toggle="modal" data-target="#modal-images" src="{{ $product->image }}" alt="{{ $product->model }}">
                            </div>

                            <div class="row">
                                @foreach($product->thumbs as $key => $thumb)
                                    <div class="col-3 p-0">
                                        <div class="m-1 p-1 border">
                                            <img class="w-100" role="button" src="{{ $thumb }}" alt="{{ $product->model }}"
                                                 onclick="$('.main-image').attr('src',  $(this).attr('src'));">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <!-- /MIDDLE -->
                </div>
            </div>
            <!-- /MAIN -->

            <!-- RIGHT -->
            <section class="col-12 col-lg-3 col-xl-3 text-center">
                <div class="mt-2">
                    <h4><span>Купить</span></h4>

                    <!-- OPTIONS -->
                    @if(count($product->skus) > 1)
                        <p>
                            <select id="product-options" class="form-control w-50 m-auto" name="options" required>
                                <option value="0" data-price="{{ number_format($product->sku->price) }}">Выберите</option>
                                @foreach($product->skus as $sku)
                                    <option value="{{ $sku->id }}" data-price="{{ $sku->price }}">
                                        @foreach($optionsConfig as $key => $config)
                                            {{ $sku->options->{$key} }}
                                        @endforeach
                                    </option>
                                @endforeach
                            </select>
                        </p>
                    @endif
                    <!-- /OPTIONS -->

                    <!-- ORDER -->
                    @if($product->is_stock)
                        <p>
                            <span id="price" class="price">
                                {{ number_format($product->price) }}
                            </span>  {{ $product->currencySign() }}
                        </p>
                        @if( $product->is_sale && !empty($product->prices->old) )
                            <p class="text-black-50 text- font-italic" style="font-size: 1.2rem; text-decoration: line-through;">
                               {{ $product->prices->old }} {{ $product->currencySign() }}
                            </p>
                        @endif

                        <button id="add-button" class="btn btn-bright w-50" role="button"
                                data-id="{{ $product->sku->id }}">В корзину</button>
                        <button id="added-button" class="btn btn-gray w-50 hidden" role="button"
                                data-target="#modal-cart" data-toggle="modal">уже в корзине</button>
                    @else
                        <p><b>нет в наличии</b></p>
                    @endif
                    <!-- /ORDER -->

                </div>
                @include('includes.product.orderinfo')
            </section>
            <!-- /RIGHT -->
        </div>

        <!-- BOTTOM -->
        <section id="product-description" class="mt-3">
            <h3><span>Описание</span></h3>
            {!! $product->text !!}
        </section>

        <section id="product-comments" class="mt-3 p-3 bg-light">
            <h3><span>Отзывы о {{ $product->model }}</span></h3>
            @include('includes.product.comment')
        </section>

        <section id="product-analogues" class="mt-3">
            <h3><span>Аналоги</span></h3>
            <div class="row w-100 text-center">
                @foreach($analogs as $item)
                    @include('includes.shop.item')
                @endforeach
            </div>
        </section>
        <!-- /BOTTOM -->
    </main>

    @include('modals.image')
    @include('modals.comment')

    @if(count($errors))
        <script>$(() => { $('#modal-add-comment').modal() })</script>
    @endif

@endsection
