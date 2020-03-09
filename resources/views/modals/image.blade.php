
@if($product->images)
    <div id="modal-images" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-images">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <h4><div>Фото {{ $product->model }}</div></h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="col-12 product-image">
                                <img class="main-image" src="{{ $product->image }}" alt="{{ $product->model }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row row-flex">
                                @foreach($product->images as $key => $image)
                                    <div class="col-4 p-1">
                                        <div class="p-1 product-image-modal border">
                                            <img class="w-100" role="button" src="{{ $image }}" alt="{{ $product->model }}"
                                                 onclick="$('.main-image').attr('src',  $(this).attr('src'));">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
