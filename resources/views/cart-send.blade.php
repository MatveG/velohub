@extends('layouts.main')

@section('content')
    <div class="content">
        <main id="cart-html" role="main" class="container rounded">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1><span>Заказ принят</span></h1>
                    <p class="text-center">Мы свяжемся с Вами для подтверждения</p>
                    <div id="products-list">
                        @include('includes.cart.products')
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </main>
    </div>
@stop
