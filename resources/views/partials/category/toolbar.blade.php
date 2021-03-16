
<section class="d-flex justify-content-between">
    <div>
        <form name="sort" action="" method="get">
            <label>
                <select class="form-select category-select-sort" size="1" name="sort">
                    <option value="" selected>сортировка</option>
                    <option value="id-desc" {{ request()->sort === 'n-o' ? 'selected' : '' }}>сначала новинки</option>
                    <option value="price-asc" {{ request()->sort === 'l-h' ? 'selected' : '' }}>сначала дешевые</option>
                    <option value="price-desc" {{ request()->sort === 'h-l' ? 'selected' : '' }}>сначала дорогие</option>
                    <option value="title-asc" {{ request()->sort === 'a-z' ? 'selected' : '' }}>по названию</option>
                </select>
            </label>
        </form>
    </div>
    <div>
        <div class="float-right pagination">{{ $products->appends(request()->query())->onEachSide(1)->links() }}</div>
    </div>
</section>
