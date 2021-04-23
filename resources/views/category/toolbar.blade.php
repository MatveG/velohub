<nav class="d-flex toolbar justify-content-between bg-light" id="toolbar">
    <ul class="nav py-2 d-none d-md-inline-flex">
        <li class="nav-item">
            <div class="nav-link">
                <a href="/" class="icon-20 icon-home align-bottom"></a>
            </div>
        </li>
        <li class="nav-item">
            <div class="nav-link px-0 fw-bold">&#8250;</div>
        </li>
        <li class="nav-item">
            <span class="nav-link">
                {{$category->title}}
            </span>
        </li>
    </ul>

    <div class="px-4 py-2">
        <form name="sort" action="" method="get">
            <label>
                <select class="form-select category-select-sort" size="1" name="sort">
                    <option value="" selected>сортировка</option>
                    <option value="id-desc" {{ request()->sort === 'id-desc' ? 'selected' : '' }}>сначала новинки</option>
                    <option value="price-asc" {{ request()->sort === 'price-asc' ? 'selected' : '' }}>сначала дешевые</option>
                    <option value="price-desc" {{ request()->sort === 'price-desc' ? 'selected' : '' }}>сначала дорогие</option>
                    <option value="title-asc" {{ request()->sort === 'title-asc' ? 'selected' : '' }}>по названию</option>
                </select>
            </label>
        </form>
    </div>
</nav>
