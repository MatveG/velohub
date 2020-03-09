
@if($res)
  @foreach($res as $menu)
    <li class="nav-item">
      <a href="{{ $menu['link'] }}" class="nav-link">{{ $menu['name'] }}</a>
    </li>
    @if(!empty($menu['child']))
      @foreach($menu['child'] as $child)
        <li class='vmenu-child'><a href="{{ $child['link'] }}">{{ $child['name'] }}</a>
      @endforeach
    @endif
  @endforeach
@endif
