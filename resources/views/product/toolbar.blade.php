<nav class="d-flex justify-content-between bg-light toolbar" id="toolbar">
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
            <a href="{{ $product->category->link }}" class="nav-link">
                {{ $product->category->title }}
            </a>
        </li>
        <li class="nav-item px-0">
            <div class="nav-link px-0 fw-bold">&#8250;</div>
        </li>
        <li class="nav-item">
            <span class="nav-link">
                {{$product->model}}
            </span>
        </li>
    </ul>

    <ul class="nav py-2">
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-description">
                Описание
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link scroll-to-id" href="#Product-comments" data-id="Product-comments">--}}
{{--                <span>Отзывы</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="nav-item">
            <a class="nav-link scroll-to-id" href="#product-analogues">
                Аналоги
            </a>
        </li>
    </ul>
</nav>

