@foreach($menuTree as $menu)
    <li class="nav-item d-none d-lg-block">
        <a href="{{ $menu->link }}" class="nav-link">
            {{ $menu->name }}
        </a>
    </li>
@endforeach
