<div class="mt-2">
    @if($filter->type === 'slider')
        @include('includes.category.filters.slider')
    @else
        <span class="fw-bold">{{ $filter->title }}</span>
        @include('includes.category.filters.plain')
    @endif
</div>
