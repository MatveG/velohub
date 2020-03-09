
@extends('layouts.master')

@section('content')
    @if(!count($products))
        <div id="error" class="hidden">Недостаточно товаров для сравнения</div>
    @endif

    <div class="content">
        <h2><span>{{ $category->name }} - сравнение</span></h2>
        <div class="overflow-auto">
            <table id="compare-table" class="table mt-4 text-center">
                <thead>
                <tr>
                    <th scope="col" class="">
                        <div class="d-flex">
                            <button id="compare-show-all" class="btn btn-sm btn-light m-1">Все</button>
                            <button id="compare-show-diff" class="btn btn-sm btn-light m-1">Отличия</button>
                        </div>
                    </th>
                    @foreach($products as $product)
                        <th scope="col">
                            <a href="{{ $product->link }}">{{ $product->brand }} {{ $product->model }}</a>
                            <button class="btn btn-sm btn-light font-weight-bold compare-remove"
                                    data-id="{{ $product->id }}">&times;</button>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" class="text-left">Фото</th>
                    @foreach($products as $product)
                        <td>
                            <span class="bright font-weight-bold">
                                {{ number_format($product->price) }}
                            </span> {{ $shop->price->sign }}
                            <br>
                            <a href="{{ $product->link }}">
                                <img class="w-50" src="{{ $product->thumb }}" alt="{{ $product->model }}">
                            </a>
                        </td>
                    @endforeach
                </tr>
                @if($category->features)
                    @foreach($category->features as $key => $feature)
                        <tr class="compare-row">
                            <th class="text-left">{{ $feature->title }}</th>
                            @foreach($products as $product)
                                <td>
                                    {{ $product->features->{$key} }}
                                    <span class="small">{{ $feature->units }}</span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
