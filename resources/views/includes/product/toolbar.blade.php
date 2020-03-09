
<nav class="navbar navbar-expand justify-content-md-between pl-4 navbar-light bg-light">
    <div>
        <a href="/" class="icon-20 icon-home align-bottom"></a>
        <strong class="p-1">&#8250;</strong>
        <a href="{{ $product->category->link }}">
            {{ $product->category->name }}
        </a>
        <strong class="p-1">&#8250;</strong>
        {{$product->model}}
    </div>

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-description" data-id="product-description">
                <span>Описание</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-comments" data-id="product-comments">
                <span>Отзывы</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-analogues" data-id="product-analogues">
                <span>Аналоги</span>
            </a>
        </li>
    </ul>
</nav>
