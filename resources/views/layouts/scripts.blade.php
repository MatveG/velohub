<div id="scroll-top" class="icon-scroll-top" role="button"></div>
<div id="error-message"></div>
<div id="shop-cart">
    <script>
        window._CHECKOUT_ROUTE = '{!! route('checkout') !!}';
    </script>
</div>

<script>
    window._CONFIG = {
        currency: {!!json_encode(setting('currency'))!!},
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
    window._STATE = {
        toast: {
            items: [
                @if(session('notice-info'))
                    {type: 'info', message: '{{session('notice-info')}}', created: Date.now()},
                @endif
                @if(session('notice-warning'))
                    {type: 'warning', message: '{{session('notice-warning')}}', created: Date.now()},
                @endif
                @if(session('notice-danger'))
                    {type: 'danger', message: '{{session('notice-danger')}}', created: Date.now()},
                @endif
            ],
        },
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app.min.js') }}"></script>
