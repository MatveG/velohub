<div class="m-auto">
    <div id="product-buy" />
</div>

<script>
    window._PRODUCT_BUY = {!!json_encode($product->only(['id', 'is_stock', 'is_sale', 'price', 'price_sale']))!!}
    window._PRODUCT_VARIANTS = {!!$product->variants!!};
</script>
