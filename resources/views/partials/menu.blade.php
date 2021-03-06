@if($menuTree)
  @foreach($menuTree as $menu)
    <li class="nav-item">
      <a href="{{ $menu->link }}" class="nav-link">{{ $menu->name }}</a>
    </li>
    @if(!empty($menu->childs))
        @foreach ($menu->childs as $child)
            @include('partials.menu-child')
        @endforeach
    @endif
  @endforeach
@endif
