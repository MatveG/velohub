@if($res)
    @foreach($res as $menu)
        <li class="nav-item dropdown pl-3">
            @if($menu['is_parent'])
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $menu['name'] }}
                </a>

                <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown">
                    @if($menu['with_filters'])
                        <a class="dropdown-item" href="{{ $menu['link'] }}">Все {{ $menu['name'] }}</a>
                    @endif

                    @foreach ($menu['child'] as $child)
                        @include('widgets.catalog-child')
                    @endforeach
                </div>
            @else
                <a class="nav-link" href="{{ $menu['link'] }}">{{ $menu['name'] }}</a>
            @endif
        </li>
    @endforeach
@endif
