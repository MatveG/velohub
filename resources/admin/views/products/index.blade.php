@extends('admin.views.layouts.master')

@section('content')
    <script>
        window.path = '/admin/products/';
        window.page = 1;
        window.limit = 25;
        window.sort = ['id', 'desc'];
    </script>

    <a class="btn btn-dark bg-dark float-right" href="add">Добавить</a>

    <table class="table" id="main-table">
        <!-- Filters Head -->
        <form id="filters" autocomplete="off">
            <input autocomplete="false" type="hidden" type="text">
            <thead>
            <tr>
                <th>
                    <input class="form-control mass-check" type="checkbox">
                </th>
                <th>
                    <input class="form-control" type="search" name="id">
                </th>
                <th>
                    <input id="defaultCheck1" type="checkbox" name="images" value="null">
                    <label for="defaultCheck1">без фото</label>
                </th>
                <th>
                    <div class="input-group">
                        <input class="form-control" id="filter-model" data-suggest="true" type="search" name="model">
                    </div>
                </th>
                <th>
                    <div class="input-group">
                        <input class="form-control" data-suggest="true" type="search" name="brand">
                    </div>
                </th>
                <th>
                    <select class="form-control" name="category_id">
                        <option value="">(Категория)</option>
                        @foreach($categories as $category)
                            @if($category->is_parent)
                                <option value="{{ $category->id }}" disabled>{{ $category->name }}</option>
                                @foreach ($category->child as $child)
                                    @include('products.includes.category')
                                @endforeach
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </th>
                <th>
                    <input class="form-control" type="checkbox" name="is_active">
                </th>
                <th>
                    <input class="form-control" type="checkbox" name="is_stock">
                </th>
                <th>
                    <input class="form-control" type="checkbox" name="is_sale">
                </th>
                <th>
                    <button class="reset btn float-right alert-danger font-weight-bold">&times;</button>
                </th>
            </tr>
            </thead>
        </form>
        <!-- /Filters Head -->

        <!-- Ajax rows -->
        <tbody id="rows">
            @include('products.includes.rows')
        </tbody>
        <!-- Ajax rows -->

        <!-- Footer -->
        <tr>
            <td>
                <input class="form-control mass-check" type="checkbox">
            </td>
            <td colspan="2">
                <select class="mass-action form-control">
                    <option>-option-</option>
                    <option value="delete">Удалить</option>
                    <option value="publish">Опубликовать</option>
                </select>
            </td>
            <td colspan="2"></td>
            <td>
                <select class="limit-select form-control">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </td>
            <td colspan="4">
                <div class="pagination float-right">
                    <button class="page-prev btn btn-dark"><</button>
                    <div class="page-number form-control ml-1 mr-1">1</div>
                    <button class="page-next btn btn-dark">></button>
                </div>
            </td>
        </tr>
        <!-- /Footer -->
    </table>


@endsection
