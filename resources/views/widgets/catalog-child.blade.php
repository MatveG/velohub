@if($child['link'] == '(divide)')
    <div class="dropdown-item disabled dropdown-divider"></div>
@else
    <a class="dropdown-item" href="{{ $child['link'] }}">{{ $child['name'] }}</a>
@endif

@if($child['is_parent'])
    <div>
        @foreach ($child['child'] as $grandson)
            @include('widgets.includes.catalog', ['child' => $grandson])
        @endforeach
    </div>
@endif
