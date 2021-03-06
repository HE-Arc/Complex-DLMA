
@foreach($comments as $comment)
<div class="card bg-light mb-3">

    <div class="card-header cd_medium-text">
        {{ $comment->user->username }}
        <span class="text-muted cd_small-text ml-1">
            {{ date('d.m.Y \a\t H:i',strtotime($comment->created_at)) }}
        </span>
    </div>

    <div class="card-body cd_medium-text">
        {{ $comment->text }}
    </div>
</div>
@endforeach