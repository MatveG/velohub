<div class="spacer"></div>

<h5><span>Кешбэк</span></h5>

<span class="price" title="Может быть использован для оплаты 30% следующего заказа или 50% сервиса">
    <span class="small">{{round($product->price * 0.07)}}</span>
</span>
<span class="small">{{ setting('currency', 'sign') }}</span>

<div class="spacer"></div>

<h5><span>Кредит</span></h5>
Оплата частями: <i>от {{ round($product->price/3) }} ₴/мес</i><br>
Рассрочка: <i>до 24 мес</i>

<div class="spacer"></div>

<h5><span>Доставка</span></h5>
Курьером по Киеву - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i><br>
До Новой Почты - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i><br>
До Интайма - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i>
