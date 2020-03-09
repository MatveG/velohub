
<option value="{{ $child->id }}" {{ (isset($product->category_id) && $product->category_id === $child->id) ? 'selected' : '' }}>
    - {{ $child->name }}
</option>

@if($child->is_parent)
    @foreach ($child->child as $sub)
        @include('products.includes.category', ['child' => $sub])
    @endforeach
@endif
