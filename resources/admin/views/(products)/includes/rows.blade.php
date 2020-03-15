
@foreach($products as $product)
    <tr>
        <td>
            <input type="checkbox" value="{{ $product->id }}">
        </td>
        <td>
            {{ $product->id }}
        </td>
        <td>
            <img style="width:100px;" src="{{ $product->thumb }}">
        </td>
        <td>
            <a href="{{ $product->link }}" target="_blank">{{ $product->model }}</a><br>
            {{ $product->latin }}
        </td>
        <td>
            {{ $product->brand }}
        </td>
        <td>
            {{ $product->category->name }}
        </td>
        <td>
            {{ $product->is_active }}
        </td>
        <td>
            {{ $product->is_stock }}
        </td>
        <td>
            {{ $product->is_sale }}
        </td>
        <td>
            <select class="row-action form-control-sm" data-id="{{ $product->id }}">
                <option value="">-action-</option>
                <option value="Edit">edit</option>
                <option value="Delete"><d></d>elete</option>
            </select>
        </td>
    </tr>
@endforeach
