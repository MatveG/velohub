<div class="mt-2">
    <strong>Цена</strong>
    <div class="d-flex justify-content-between form-group">
        <label for="prc_min">
            <input class="form-control category-filter" name="price" value="{{$filter->values[0]}}">
        </label>
        <div class="p-2">до</div>
        <label for="prc_min">
            <input class="form-control category-filter" name="price" value="{{$filter->values[1]}}">
        </label>
    </div>
</div>
