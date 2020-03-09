
<ul class="media-list p-0">
    @foreach($comments as $comment)
        <li class="media mt-3 p-3 bg-white rounded">
            <div class="media-body">
                <span class="text-muted float-right">
                    <small class="text-muted">{{ date('d-m-Y', strtotime($comment->created_at)) }}</small>
                </span>
                @<i>{{ $comment->author }}</i>
                @if($comment->pros)
                    <div class="mt-2"><b>Достоинства:</b> {{ $comment->pros }}</div>
                @endif
                @if($comment->cons)
                    <div class="mt-2"><b>Недостатки:</b> {{ $comment->cons }}</div>
                @endif
                <div class="mt-2">{{ $comment->text }}</div>
            </div>
        </li>
    @endforeach
</ul>

<div class="text-center">
    <button class="btn btn-dark" role="button" data-toggle="modal" data-target="#modal-add-comment">
        <span>Написать свой отзыв</span>
    </button>
</div>
