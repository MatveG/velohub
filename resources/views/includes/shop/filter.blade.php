@if($filter->values)
    <div class="pt-2">
        <b>{{ $filter->title }}</b>
        @foreach($filter->values as $val => $bool)
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input shop-filter-checkbox" id="{{ $name }}{{ $val }}"
                       name="{{ $name }}" value="{{ $val }}" {{ ($bool) ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ $name }}{{ $val }}">
                    {{ $val }} {{ $filter->units ?? '' }}
                </label>
            </div>
    @endforeach
    </div>
@endif
