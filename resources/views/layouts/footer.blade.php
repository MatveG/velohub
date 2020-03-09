
<footer class="block">
    <div class="col p-0 text-center">
        <h3><span>Вело подписка</span></h3>
        <p>Одно письмо в месяц с приятными скидками, акциями и информацией о новинках</p>
        <form class="p-0 col-lg-6 col-md-8 col-sm-12 form m-auto" method="post" action="{{ route('mailing.store') }}">
            @csrf
            <div class="input-group">
                <label>
                    <input type="search" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                </label>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-bright">Подписаться</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-3">
        <div class="col-sm-2 pt-4">
            <h5><span>Навигация</span></h5>
            <ul class="nav flex-column">
                @widget('menu')
            </ul>
        </div>

        <div class="col-sm-4 pt-4">
            <h5><span>Наши контакты</span></h5>
            @widget('text', 'footer-contacts')
        </div>

        <div class="col-sm-4 pt-4">
            <h5><span>Наши магазины</span></h5>
            @widget('text', 'footer-address')
        </div>

        <div class="col-sm-2 pt-4">
            <h5><span>Принимаем</span></h5>
            <div class="text-center">
                <img src="/media/ul/visa-mc.png" width="90" height="90" alt=""><br>
                <img src="/media/ul/chast.png" width="110" height="68" alt="">
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center small">&copy; velohub.com.ua</div>
</footer>
