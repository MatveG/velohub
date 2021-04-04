@extends('layouts.checkout')

@section('content')
    <main role="main" class="content p-5">

        <div class="row">
            <div class="col-7 px-4">
                <h4><span>Ваш заказ</span></h4>

                <div class="card shadow-sm p-2">
                    <div class="card-body">
                        <div id="checkout-cart"></div>
                    </div>
                </div>
            </div>

            <div class="col-5 px-4">
                <div id="checkout-form"></div>
            </div>
        </div>
    </main>
@stop
