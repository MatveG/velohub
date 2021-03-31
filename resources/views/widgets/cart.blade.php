
@if(empty($items))
    <i>Здесь пока еще пусто</i>
@else
    <div class="table-responsive p-3">
        <table class="table text-center">
            <thead>
            <tr class="border border-left-0 border-right-0">
                <th scope="col" class="border-0"><div class="py-2 text-uppercase">Удалить</div></th>
                <th scope="col" class="border-0"><div class="p-2 px-3 text-uppercase">Наименование</div></th>
                <th scope="col" class="border-0"><div class="py-2 text-uppercase">Цена</div></th>
                <th scope="col" class="border-0"><div class="py-2 text-uppercase">Кол-во</div></th>
                <th scope="col" class="border-0"><div class="py-2 text-uppercase">Сумма, ₴</div></th>
            </tr>
            </thead>
            <tbody>

            @foreach($items as $item)
                <tr>
                    <td class="border-0 align-middle">
                        <button class="btn btn-sm btn-gray btn-cart-remove" data-id="{{ $item->id }}">&times;</button>
                    </td>
                    <th scope="row" class="border-0 text-left">
                        <div class="p-2">
                            <img src="{{ $item->image }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                            <div class="ml-3 d-inline-block align-middle">
                                <h5 class="mb-0">
                                    <a href="{{ $item->product->link }}" class="text-dark d-inline-block align-middle">
                                        {{ $item->product->firm }} {{ $item->product->model }}
                                    </a>
                                </h5>
                                <span class="text-muted font-weight-normal font-italic d-block">{{ $item->title }}</span>
                            </div>
                        </div>
                    </th>
                    <td class="border-0 align-middle">{{ $item->price }}</td>
                    <td class="border-0 align-middle text-center">
                        <div class="nowrap">
                            <a href="#" data-id="{{ $item->id }}" class="btn btn-sm btn-gray btn-cart-decrease">-</a>&nbsp;
                            <span id="amount-{{ $item->id }}" class="font-weight-bold">{{ $item->amount }}</span>&nbsp;
                            <a href="#" data-id="{{ $item->id }}" class="btn btn-sm btn-gray btn-cart-increase">+</a>
                        </div>
                    </td>
                    <td class="border-0 align-middle">{{ $item->sum }}</td>
                </tr>
            @endforeach

            <tr class="border border-left-0 border-right-0">
                <td class="border-0 align-middle text-right text-uppercase" colspan="4"><strong>Итого:</strong></td>
                <td class="border-0 align-middle"><strong>{{ $items->sum('sum') }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button class="btn btn-gray border" data-dismiss="modal">Продолжить покупки</button>
        <a href="{{ route('cart.form') }}" class="btn btn-bright border">Оформить заказ</a>
    </div>
@endif
