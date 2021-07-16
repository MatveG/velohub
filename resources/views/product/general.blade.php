<h1><span>{{ $product->name }} {{$product->model}}</span></h1>

{{--        <div class="text-right">--}}
{{--            <button class="btn btn-sm btn-light compare-toggle" role="button">--}}
{{--                в сравнение--}}
{{--            </button>--}}
{{--        </div>--}}

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
    @foreach($product->category->features as $feature)
        @if(!empty($product->features[$feature['id']]))
            <span>{{ $feature['title'] }}:
                <i>{{ $product->features[$feature['id']] }} {{ $feature['units'] }}</i>
            </span><br>
        @endif
    @endforeach
@endif
