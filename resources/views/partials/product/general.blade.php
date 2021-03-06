<div class="row">
    <div class="col-12 col-lg-6 col-xl-6">
        <h1><span>{{ $product->name }} {{$product->model}}</span></h1>

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

        <p>{{ $product->preview }}</p>

        @if($product->category->features)
            <div class="spacer"></div>
            @foreach($product->category->features as $key => $feature)
                <span>{{ $feature->title }}: <i>{{ $product->features->{$key} }} {{ $feature->units }}</i></span><br>
            @endforeach
        @endif
    </div>

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
</div>
