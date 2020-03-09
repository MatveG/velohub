
@extends('admin::layouts.master')

@section('content')

{{--    <form>--}}
{{--        <!-- id -->--}}
{{--        <div class="form-group row">--}}
{{--            <label class="col-sm-3 col-form-label">ID</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input class="form-control" name="id" type="text"  disabled value="{{ $product->id }}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- is_active -->--}}
{{--        <div class="form-group row">--}}
{{--            <label for="id" class="col-sm-3 col-form-label">Публиковать</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input class="form-check-input" id="exampleCheck1" type="checkbox">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- category_id -->--}}
{{--        <div class="form-group row">--}}
{{--            <label for="id" class="col-sm-3 col-form-label">Категория</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <select class="form-control" name="category_id">--}}
{{--                    <option value="">(Категория)</option>--}}
{{--                    @foreach($categories as $category)--}}
{{--                        @if($category->is_parent)--}}
{{--                            @foreach ($category->child as $child)--}}
{{--                                @include('products.includes.category')--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <option value="{{ $category->id }}" {{ ($product->category_id === $category->id) ? 'selected' : '' }}>--}}
{{--                                {{ $category->name }}--}}
{{--                            </option>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- name -->--}}
{{--        <div class="form-group row">--}}
{{--            <label for="id" class="col-sm-3 col-form-label">Наименование</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input class="form-control" id="id" name="id" type="text"  value="{{ $product->name }}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- brand -->--}}
{{--        <div class="form-group row">--}}
{{--            <label for="brand" class="col-sm-3 col-form-label">Бренд</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input class="form-control" id="brand" name="brand" type="text"  value="{{ $product->brand }}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- model -->--}}
{{--        <div class="form-group row">--}}
{{--            <label for="model" class="col-sm-3 col-form-label">Модель</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input class="form-control" name="model" type="text"  value="{{ $product->model }}">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- features -->--}}

{{--        <!-- preview -->--}}
{{--        <div class="form-group row">--}}
{{--            <label class="col-sm-3 col-form-label" for="preview">Короткое описание</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <textarea class="form-control" id="preview" name="preview" rows="2">{{ $product->preview }}</textarea>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- text -->--}}
{{--        <div class="form-group row">--}}
{{--            <label class="col-sm-3 col-form-label" for="text">Полное описание</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <textarea class="form-control" id="text" name="text" rows="4">{{ $product->text }}</textarea>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--        <!-- features -->--}}
{{--        <div class="bg-light p-3">--}}
{{--            @if($product->category->features)--}}
{{--                @foreach($product->category->features as $key => $feature)--}}
{{--                    <div class="form-group row">--}}
{{--                        <label for="model" class="col-sm-3 col-form-label">{{ $feature->title }} ({{ $feature->units }})</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <input class="form-control" name="model" type="text"  value="{{ $product->features->{$key} }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </div>--}}


{{--        <div>--}}
{{--            <!-- latin -->--}}
{{--            <div class="form-group row">--}}
{{--                <label for="latin" class="col-sm-3 col-form-label">SEO url</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                    <input class="form-control" id="latin" name="latin" type="text"  value="{{ $product->latin }}">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- seo_title -->--}}
{{--            <div class="form-group row">--}}
{{--                <label for="seo_title" class="col-sm-3 col-form-label">SEO title</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                    <input class="form-control" id="seo_title name="seo_title" type="text"  value="{{ $product->seo_title }}">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- seo_description -->--}}
{{--            <div class="form-group row">--}}
{{--                <label for="seo_description" class="col-sm-3 col-form-label">SEO description</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                    <input class="form-control" id="seo_description" name="seo_description" type="text"  value="{{ $product->seo_description }}">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- seo_keywords -->--}}
{{--            <div class="form-group row">--}}
{{--                <label for="seo_keywords" class="col-sm-3 col-form-label">SEO keywords</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                    <input class="form-control" id="seo_keywords" name="seo_keywords" type="text"  value="{{ $product->seo_keywords }}">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}

    <list></list>

@endsection
