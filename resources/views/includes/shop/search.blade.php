
<form class="form m-auto" method="get" action="{{ route('product.search') }}">
    <div class="input-group">
        <input type="search" class="form-control" name="find"
               placeholder="Поиск товара" value="{{ request('find') }}" required>
        <div class="input-group-append">
            <button type="submit" class="btn btn-bright">Поиск</button>
        </div>
    </div>
</form>
