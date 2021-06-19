@foreach($_categoryTree as $category)
    <li class="nav-item dropdown">
        @if($category->is_parent)
            <a id="dropdown-{{$category->id}}" class="nav-link" href="#" type="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $category->title }}
            </a>

            <div class="dropdown-menu rounded-0" aria-labelledby="dropdown-{{$category->id}}">
                @foreach ($category->children as $child)
                    @include('includes.header.catalog-child')
                @endforeach
            </div>
        @else
            <a class="nav-link" href="{{ $category->link }}">{{ $category->title }}</a>
        @endif
    </li>
@endforeach
