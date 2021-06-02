<p>
    <h5><span>Кешбэк</span></h5>

    <span class="big bright"><b>{{round($product->price * 0.07)}}</b></span>
    <span>{{ setting('currency', 'sign') }}</span><br/>
    <span class="small">
        до 30% на товары<br/>
        до 50% на услуги
    </span>
</p>

<p>
    <h5><span>Доставка</span></h5>

    <span class="small">
        По Киеву - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i><br/>
        Новая Почта - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i><br/>
        Интайм, Meest - <i>{{ $product->price > 2500 ? 'бесплатно' : '50 грн'}}</i>
    </span>
</p>

<p>
    <h5><span>Кредит</span></h5>

    <span class="small">
        Оплата частями:<br><i>{{ round($product->price/3) }} ₴/мес</i><br/>
        Рассрочка:<br><i>до 24 мес</i>
    </span>
</p>
