<div id="loader" class="loader"><div class="bar"></div></div>
<div id="scroll-top" class="icon-scroll-top" role="button"></div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app.min.js') }}"></script>

@if(session('notify'))
    <script>
        $(() => {
            notify('{{ session('notify') }}');
        });
    </script>
@endif
