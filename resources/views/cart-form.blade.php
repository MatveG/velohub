@extends('layouts.master')

@section('content')
    <div class="content">
        <main id="cart-html" role="main" class="container rounded">
            <h1><span>Корзина покупок</span></h1>
            @if(!count($items))
                <p class="text-center">
                    <i>В корзине нет ни одного товара</i>
                </p>
            @else
                @if(count($errors))
                    <div class="alert alert-danger text-center" role="alert">Заполните корректно все поля</div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3><span>Список товаров</span></h3>
                        @include('includes.cart.products')
                        <div class="text-center">
                            <button class="btn btn-gray w-50" data-target="#modal-cart" data-toggle="modal">Редактировать</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h3><span>Данные получателя</span></h3>
                        @include('includes.cart.form')
                    </div>
                </div>
            @endif
        </main>
    </div>
@stop
