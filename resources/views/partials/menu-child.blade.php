@foreach($menu->childs as $child)
    <li class='vmenu-child'><a href="{{ $child->link }}">{{ $child->name }}</a>
    @if($menu->childs)
        @foreach ($child->childs as $child)
            @include('partials.menu-child')
        @endforeach
    @endif
@endforeach
