<div class="mt-2">
    @if($filter->type === 'slider')
        @include('category.filters.slider')
    @else
        <span class="fw-bold">{{ $filter->title }}</span>
        @include('category.filters.plain')
    @endif
</div>
