<div id="scroll-top" class="icon-scroll-top" role="button"></div>
<div id="error-message"></div>
<div id="shop-cart">
    <script>
        window._CHECKOUT_ROUTE = '{!! route('checkout') !!}';
    </script>
</div>

<script>
    window._CONFIG = {
        currency: {!!json_encode(settings('shop', 'currency'))!!},
        payments: [
            {
                id: 1,
                title: 'Наличными',
                multiplier: 1,
            },
        ],
        couriers: [
            {
                id: 1,
                title: 'Самовывоз с магазинов',
                cost: 0,
                free: 0,
            },
            {
                id: 2,
                title: 'Курьером по Киеву и области',
                cost: 50,
                free: 20000,
            },
            {
                id: 3,
                title: 'Новой Почтой',
                cost: 90,
                free: 3000,
            },
            {
                id: 4,
                title: 'Деливери',
                cost: 50,
                free: 2000,
            }
        ]
    }

    @if(session('notice-info'))
        window._NOTICE_INFO = {{session('info')}};
    @endif

    @if(session('notice-warning'))
        window._NOTICE_WARNING = {{session('warning')}};
    @endif

    @if(session('notice-danger'))
        window._NOTICE_DANGER = {{session('danger')}};
    @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app.min.js') }}"></script>
