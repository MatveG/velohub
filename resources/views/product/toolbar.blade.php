<nav class="navbar navbar-expand px-3 justify-content-md-between navbar-light bg-light">
    <ul class="navbar-nav d-none d-md-inline-flex">
        <li class="nav-item">
            <a href="/" class="icon-20 icon-home align-bottom"></a>
        </li>
        <li class="nav-item px-2"><strong>&#8250;</strong></li>
        <li class="nav-item">
            <a href="{{ $product->category->link }}">
                {{ $product->category->title }}
            </a>
        </li>
        <li class="nav-item px-2"><strong>&#8250;</strong></li>
        <li class="nav-item">
            {{$product->model}}
        </li>
    </ul>

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-description" data-id="product-description">
                <span>Описание</span>
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link scroll-to-id" href="#Product-comments" data-id="Product-comments">--}}
{{--                <span>Отзывы</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-analogues" data-id="product-analogues">
                <span>Аналоги</span>
            </a>
        </li>
    </ul>
</nav>

