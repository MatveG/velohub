
<div id="modal-add-comment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <h4><div>Добавить свой отзыв</div></h4>
            <div class="modal-body">
                @if(count($errors))
                    <div class="alert alert-danger text-center" role="alert">Заполните корректно все поля</div>
                @endif
                <form class="form-horizontal" action="{{ route('comment.store', ['product_id' => $product->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Общая оценка*</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating-radio-1" required
                                   value="1" {{ (old('rating') && old('rating') == '1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rating-radio-1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating-radio-2" value="2"
                                   value="2" {{ (old('rating') && old('rating') == '2') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rating-radio-2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating-radio-3" value="3"
                                   value="3" {{ (old('rating') && old('rating') == '3') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rating-radio-3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating-radio-4" value="4"
                                   value="4" {{ (old('rating') && old('rating') == '4') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rating-radio-4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating-radio-5" value="5"
                                   value="5" {{ (old('rating') && old('rating') == '5') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rating-radio-5">5</label>
                        </div>
                        @error('rating')
                            <small class="d-block text-left text-danger">обязательное поле</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Достоинства</label>
                        <input class="form-control" name="pros" value="{{ old('pros') }}" type="text">
                    </div>
                    <div class="form-group">
                        <label>Недостатки</label>
                        <input class="form-control" name="cons" value="{{ old('cons') }}" type="text">
                    </div>
                    <div class="form-group">
                        <label>Комментарий*</label>
                        <textarea class="form-control" name="text" required>{{ old('text') }}</textarea>
                        @error('text')
                            <small class="d-block text-center text-danger">обязательное поле</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Имя*</label>
                        <input class="form-control" name="author" value="{{ old('author') }}" type="text">
                        @error('author')
                            <small class="d-block text-center text-danger">обязательное поле</small>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
