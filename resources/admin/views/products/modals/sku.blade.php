
<div id="modal-sku-{{ $sku->id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="form-sku-{{ $sku->id }}" method="put" action="/admin/sku/patch/">
                    <input type="hidden" name="id" value="{{ $sku->id }}">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="title-{{ $sku->id }}">Наименование</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title-{{ $sku->id }}" name="title" value="{{ $sku->title }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="barcode-{{ $sku->id }}">Штрих-код</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barcode-{{ $sku->id }}" name="barcode" value="{{ $sku->barcode }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="codes-{{ $sku->id }}">Артикулы</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="codes-{{ $sku->id }}" name="codes"
                                  rows="2" required>@foreach($sku->codes as $code){{ $code }}&#13;&#10;@endforeach</textarea>
                        </div>
                    </div>

                    @foreach($product->category->options as $key => $option)
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="option-{{ $key }}{{ $sku->id }}">{{ $option->title }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="option-{{ $key }}{{ $sku->id }}" name="options[{{ $key }}]" value="">
                            </div>
                        </div>
                    @endforeach

                    @foreach(settings('shop', 'stocks') as $key => $stock)
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="stock-{{ $key }}{{ $sku->id }}">{{ $stock->name }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stock-{{ $key }}{{ $sku->id }}" name="stocks[{{ $key }}]" value="">
                            </div>
                        </div>
                    @endforeach

                    @foreach(settings('shop', 'prices') as $key => $price)
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="price-{{ $key }}{{ $sku->id }}"></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="price-{{ $key }}{{ $sku->id }}" name="prices[{{ $key }}]">
                            </div>
                        </div>
                    @endforeach

                    <div id="sku-alert-{{ $sku->id }}" class="alert collapse" role="alert"></div>

                    <div class="text-center">
                        <button class="btn btn-dark" type="submit">Сохранить</button>
                        <button class="btn btn-light" data-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </form>

{{--                <script>--}}
{{--                    $('#form-sku-{{ $sku->id }}').submit(function() {--}}
{{--                        let skuAlert = $('#sku-alert-{{ $sku->id }}');--}}
{{--                        $.ajax({--}}
{{--                            data: $(this).serialize(),--}}
{{--                            type: $(this).attr('method'),--}}
{{--                            url: $(this).attr('action'),--}}

{{--                            success: function(response) {--}}
{{--                                $(skuAlert).addClass( (response.ok === 1) ? 'alert-success' : 'alert-danger' );--}}
{{--                                $(skuAlert).html(response.ans);--}}
{{--                                $(skuAlert).fadeIn(200);--}}
{{--                                setTimeout(() => {--}}
{{--                                    $(skuAlert).fadeOut(200);--}}
{{--                                }, 3000);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        return false;--}}
{{--                    });--}}
{{--                </script>--}}
            </div>
        </div>
    </div>
</div>
