<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $reply->owner->name }} said {{ $reply->created_at->diffForHumans() }}</div>
            <div class="panel-body">
                <div class="body">{{ $reply->body }}</div>
            </div>
        </div>
    </div>
</div>