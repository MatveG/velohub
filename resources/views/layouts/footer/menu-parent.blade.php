@foreach($menuTree as $menu)
    <li class="nav-item">
        <a href="{{ $menu->link }}" class="nav-link">
            {{ $menu->name }}
        </a>
    </li>
    @if($menu->is_parent)
        @foreach ($menu->children as $child)
            @include('layouts.footer.menu-child')
        @endforeach
    @endif
@endforeach
