@if($items)
    <div class="table-responsive">
        <table class="table text-center">
            <tbody>

            @foreach($items as $item)
                <tr>
                    <td>
                        <a href="{{ $item->product->link }}">
                            <img class="img-fluid rounded" src="{{ $item->image }}" width="100" alt="">
                        </a>
                    </td>
                    <td class="text-left p-4 align-middle">
                        <a href="{{ $item->product->link }}">{{ $item->product->firm }} {{ $item->product->model }}</a>
                    </td>
                    <td class="text-muted font-italic align-middle">{{ $item->amount }} шт</td>
                    <td class="align-middle">{{ $item->sum }}</td>
                </tr>
            @endforeach

            <tr class="border border-left-0 border-right-0">
                <td class="border-0 align-middle" colspan="3"><strong>Итого:</strong></td>
                <td class="border-0 align-middle"><strong>{{ $items->sum('sum') }} грн</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
@endif
