<footer class="block">
    <div class="row mt-3">
        <div class="col-sm-2 pt-4">
            <h5><span>Навигация</span></h5>
            <ul class="nav flex-column">
                @if($menuTree)
                    @include('layouts.footer.menu')
                @endif
            </ul>
        </div>

        <div class="col-sm-4 pt-4">
            <h5><span>Наши контакты</span></h5>
            @widget(footer-contacts)
        </div>

        <div class="col-sm-4 pt-4">
            <h5><span>Наши магазины</span></h5>
            @widget(footer-address)
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
