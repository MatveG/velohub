
<div class="bg-light p-3">
    <table class="table text-center" id="main-table">
        <thead>
        <tr>
            <th>default</th>
            <th>is_active</th>
            <th>codes</th>
            <th>title</th>
            <th>barcode</th>
            <th>action</th>
        </tr>
        </thead>

        <tbody>
            @foreach($product->skus as $sku)
                <tr>
                    <td>
                        <input class="sku-set-default" name="is_default" data-id="{{ $sku->id }}" type="radio" {{ ($sku->is_default) ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input class="sku-set-active" name="is_active" data-id="{{ $sku->id }}" type="checkbox" {{ ($sku->is_active) ? 'checked' : '' }}>
                    </td>
                    <td class="small">
                        @foreach($sku->codes as $code)
                            {{ $code }}<br>
                        @endforeach
                    </td>
                    <td>{{ $sku->title }}</td>
                    <td>{{ $sku->barcode }}</td>
                    <td>
                        <button class="btn btn-dark" data-toggle="modal" data-target="#modal-sku-{{ $sku->id }}"
                                role="button" type="button">edit</button>
                        <button class="sku-delete btn btn-danger" data-id="{{ $sku->id }}" role="button" type="button">X</button>
                    </td>
                </tr>
                @include('admin::(products).modals.sku')
            @endforeach
        </tbody>
    </table>
</div>
