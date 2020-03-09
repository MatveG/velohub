
<div class="item-product col-sm-4">
    <div class="d-flex mb-1 justify-content-between">
        @if(!empty($item->features->year))
            <div class="item-title-left">{{ $item->features->year }}</div>
        @else
            <div></div>
        @endif
        <button class="btn btn-sm btn-light compare-toggle" role="button" data-id="{{ $item->id }}">
            сравнить
        </button>
    </div>

    <a href="{{ $item->link }}">
        <div class="item-image">
            <img src="{{ $item->thumb }}" alt="{{ $item->model }}">
        </div>
        <div class="item-link">{{ $item->brand }} {{ $item->model }}</div>
    </a>

    <div class="item-price">
        {{ $item->price }}
    </div>
</div>
