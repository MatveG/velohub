<a class="dropdown-item" href="{{ $child->link }}">
    {{ $child->title }}
</a>

@if($child->is_parent)
    <div>
        @foreach ($child->children as $child)
            @include('widgets.includes.catalog')
        @endforeach
    </div>
@endif
