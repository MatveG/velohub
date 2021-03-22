@extends('layouts.checkout')

@section('content')
    <main role="main" class="content row py-4">
        <div class="col-6">
            <h4>
                <span>Ваш заказ</span>
            </h4>
            <div id="shopping-cart"></div>
        </div>
        <div class="col-6">
            <h4>
                <span>Ваши данные</span>
            </h4>
            <div id="checkout-form"></div>
        </div>
    </main>
@stop
