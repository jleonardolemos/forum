<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
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
</div>