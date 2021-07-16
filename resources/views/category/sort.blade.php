<form class="w-100" name="sort" action="/" method="get">
    <label class="w-100">
        <strong>Сортировка</strong>
        <select class="form-select select-sort w-100" size="1" name="sort">
            <option value="" selected>по умолчанию</option>
            <option value="id-desc" {{ request('sort') === 'id-desc' ? 'selected' : '' }}>сначала новинки</option>
            <option value="price-asc" {{ request('sort') === 'price-asc' ? 'selected' : '' }}>сначала дешевые</option>
            <option value="price-desc" {{ request('sort') === 'price-desc' ? 'selected' : '' }}>сначала дорогие</option>
            <option value="title-asc" {{ request('sort') === 'title-asc' ? 'selected' : '' }}>по названию</option>
        </select>
    </label>
</form>
