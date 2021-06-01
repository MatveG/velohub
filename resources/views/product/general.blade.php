<h1><span>{{ $product->name }} {{$product->model}}</span></h1>

{{--        <div class="text-right">--}}
{{--            <button class="btn btn-sm btn-light compare-toggle" role="button">--}}
{{--                в сравнение--}}
{{--            </button>--}}
{{--        </div>--}}

<p>{{ $product->preview }}</p>

<table class="table table-hover small">
    <tr>
        <td><b>Код товара</b></td>
        <td><i>{{ $product->id }}</i></td>
    </tr>
    <tr>
        <td><b>Бренд</b></td>
        <td><i>{{ $product->brand }}</i></td>
    </tr>
    <tr>
        <td><b>Модель</b></td>
        <td><i>{{ $product->model }}</i></td>
    </tr>
    @if($product->category->features)
        @foreach($product->category->features as $feature)
            @if(!empty($product->features[$feature->key]))
                <tr>
                    <td class="py-1">{{ $feature->title }}</td>
                    <td class="py-1"><i>{{ $product->features[$feature->key] }} {{ $feature->units }}</i></td>
                </tr>
            @endif
        @endforeach
    @endif
</table>
