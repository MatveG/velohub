
<form class="form" action="{{ route('cart.send') }}" method="post">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="name">Имя</label>
        <div class="col-sm-10">
            <input class="form-control" value="{{ old('name') }}" name="name" placeholder="Имя" type="text" required>
            @error('name')
                <small class="d-block text-right text-danger">обязательное поле</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="phone">Телефон</label>
        <div class="col-sm-10">
            <input class="form-control" value="{{ old('phone') }}" name="phone" placeholder="Телефон для связи" type="text" required>
            @error('phone')
                <small class="d-block text-right text-danger">обязательное поле</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="email">E-mail</label>
        <div class="col-sm-10">
            <input class="form-control" value="{{ old('email') }}" name="email" placeholder="E-mail" type="email">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="address">Адрес</label>
        <div class="col-sm-10">
            <input class="form-control" value="{{ old('address') }}" name="address" placeholder="Адрес доставки" type="text" required>
            @error('address')
            <small class="d-block text-right text-danger">обязательное поле</small>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <select class="browser-default custom-select" name="payment" required>
            <option value="">Способ доставки</option>
            <option value="1" {{ (old('payment') == '1' ? 'selected' : '') }}>По Киеву</option>
            <option value="2" {{ (old('payment') == '2' ? 'selected' : '') }}>Новой Почтой</option>
            <option value="3" {{ (old('payment') == '3' ? 'selected' : '') }}>Justin</option>
        </select>
        @error('payment')
            <small class="d-block text-right text-danger">обязательное поле</small>
        @enderror
    </div>
    <div class="form-group">
        <select class="browser-default custom-select" name="shipping" required>
            <option value="">Способ оплаты</option>
            <option value="1" {{ (old('shipping') == '1' ? 'selected' : '') }}>Наличными</option>
            <option value="2" {{ (old('shipping') == '2' ? 'selected' : '') }}>ПриватБанк</option>
            <option value="3" {{ (old('shipping') == '3' ? 'selected' : '') }}>Безнал</option>
        </select>
        @error('shipping')
            <small class="d-block text-right text-danger">обязательное поле</small>
        @enderror
    </div>
    <div class="form-group">
        <textarea class="form-control" name="comment" rows="2" placeholder="Дополнительные пожелания">{{ old('comment') }}</textarea>
    </div>
    <div class="text-center">
        <button class="btn bg-bright w-50" type="submit">Подтвердить</button>
    </div>
</form>
