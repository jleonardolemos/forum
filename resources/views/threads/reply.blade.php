<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('users.show', $reply->owner->name) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans()
                }}
            </h5>
            <div>
                <form method="POST" action="{{ route('replies.favorite', $reply->id) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-default" {{ $reply->isFavorite() ? 'disabled' : '' }}>{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
    @can('delete', $reply)
    <div class="panel-footer">
        <form action="{{ route('threads.replies.delete', [
            'channel' => $reply->thread->channel->slug,
            'thread' => $reply->thread->id,
            'reply' => $reply->id,
        ]) }}" method="post">
            {{ csrf_field() }} {{ method_field('DELETE') }}
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endcan
</div>