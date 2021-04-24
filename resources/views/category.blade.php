@extends('layouts.main')

@section('path')
    <li class="nav-item">
        <div class="nav-link px-0 fw-bold">&#8250;</div>
    </li>
    <li class="nav-item">
        <span class="nav-link">
            {{$category->title}}
        </span>
    </li>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <aside class="col-md-2 pr-lg-3">
                @include('category.filters')
            </aside>

            <div class="col-md-10">
                <h2><span>{{ $meta->title }}</span></h2>

                <main class="mt-3 mb-3">
                    <div class="row text-center">
                        <div style="float: left;">
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

                        @if(!$products)
                            <div class="col-12 text-center">
                                <i>По данному запросу не найдено ни одного товара.</i>
                            </div>
                        @endif

                        @foreach($products as $product)
                            @include('category.product')
                        @endforeach
                    </div>

                    <div class="pagination-lg flex-wrap my-4">
                        {{ $products->appends(request()->query())->onEachSide(1)->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
