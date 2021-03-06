<div class="mt-2">
    <h4><span>Купить</span></h4>

    @if(count($product->variants) > 1)
        <p>
            <select id="product-options" class="form-control w-50 m-auto" name="options" required>
                <option value="0" data-price="{{ number_format($product->variant->price) }}">Выберите</option>
                @foreach($product->variants as $variant)
                    <option value="{{ $variant->id }}" data-price="{{ $variant->price }}">
                        @foreach($optionsConfig as $key => $config)
                            {{ $variant->options->{$key} }}
                        @endforeach
                    </option>
                @endforeach
            </select>
        </p>
    @endif

    @if($product->is_stock)
        <p>
            <span id="price" class="price">
                {{ number_format($product->price) }}
            </span>
{{--            {{ $product->currencySign() }}--}}
        </p>
        @if( $product->is_sale && !empty($product->prices->old) )
            <p class="text-black-50 text- font-italic" style="font-size: 1.2rem; text-decoration: line-through;">
                {{ $product->prices->old }}
                {{--                                {{ $product->currencySign() }}--}}
            </p>
        @endif

        <button id="add-button" class="btn btn-bright w-50" role="button"
                data-id="{{ $product->variants[0]->id }}">В корзину</button>
        <button id="added-button" class="btn btn-gray w-50 hidden" role="button"
                data-target="#modal-cart" data-toggle="modal">уже в корзине</button>
    @else
        <p><b>нет в наличии</b></p>
    @endif
</div>
