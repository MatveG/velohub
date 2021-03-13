@foreach($menu->children as $child)
    <li class='vmenu-child'><a href="{{ $child->link }}">{{ $child->name }}</a>
    @if($menu->children)
        @foreach ($child->children as $child)
            @include('partials.menu-child')
        @endforeach
    @endif
@endforeach
