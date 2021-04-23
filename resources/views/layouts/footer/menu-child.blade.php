@foreach($menu->children as $child)
    <li class='nav-item'>
        <a href="{{ $child->link }}">
            {{ $child->name }}
        </a>
    </li>
    @if($menu->children)
        @foreach ($child->children as $child)
            @include('layouts.footer.menu-child')
        @endforeach
    @endif
@endforeach
