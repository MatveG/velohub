@foreach($_menuTree as $menu)
    <li class="nav-item">
        <a href="{{ $menu->link }}" class="nav-link">
            {{ $menu->name }}
        </a>
    </li>
@endforeach
