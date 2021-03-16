<div class="item-product col-sm-4">
    <div class="d-flex mb-1 justify-content-between">
        @if(!empty($product->features->year))
            <div class="item-title-left">{{ $product->features->year }}</div>
        @else
            <div></div>
        @endif
{{--        <button class="btn btn-sm btn-light compare-toggle" role="button" data-id="{{ $product->id }}">--}}
{{--            сравнить--}}
{{--        </button>--}}
    </div>

    <a href="{{ $product->link }}">
        <div class="item-image">
            <img src="{{ $product->thumb }}" alt="{{ $product->model }}">
        </div>
        <div class="item-link">{{ $product->brand }} {{ $product->model }}</div>
    </a>

    <div class="item-price">
        {{ $product->price }}
    </div>
</div>
