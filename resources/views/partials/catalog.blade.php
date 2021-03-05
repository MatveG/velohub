@if($categoryTree)
    @foreach($categoryTree as $category)
        <li class="nav-item dropdown pl-3">
            @if($category->is_parent)
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $category->title }}
                </a>

                <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown">
                    @foreach ($category->childs as $child)
                        @include('partials.catalog-child')
                    @endforeach
                </div>
            @else
                <a class="nav-link" href="{{ $category->link }}">{{ $category->title }}</a>
            @endif
        </li>
    @endforeach
@endif
