
@if(!count($res))
    <i>Недостаточно товаров для сравнения</i>
@else
    Сравнить:
    @foreach($res as $item)
        <div class="d-inline ml-1">
            <a href="{{ $item->category->link }}compare/">{{ $item->category->name }}</a>
            <span class="small">({{ $item->amount }})</span>
        </div>
    @endforeach
    <button id="compare-reset" class="btn btn-sm ml-1 btn-gray font-italic">очистить</button>
@endif
