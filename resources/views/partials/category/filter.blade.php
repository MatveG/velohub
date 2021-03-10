@foreach($filter->getValues() as $value)
    <div class="custom-control custom-checkbox">
        <input id="{{ $filter->column }}-{{ $value }}"
               class="custom-control-input shop-filter-checkbox"
               type="checkbox"
               name="{{ $filter->slug }}"
               value="{{ $value }}"
               {{ ($filter->inParams($value)) ? 'checked' : '' }}>

        <label class="custom-control-label" for="{{ $filter->column }}-{{ $value }}">
            {{ $value }} {{ $filter->units }}
        </label>
    </div>
@endforeach

