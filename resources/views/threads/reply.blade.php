<reply :attributes="{{ $reply }}" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('users.show', $reply->owner->name) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans()
                    }}
                </h5>
                <div>
                <favorite :reply="{{ $reply }}"></favorite>
                    {{--  <form method="POST" action="{{ route('replies.favorite', $reply->id) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-default" {{ $reply->isFavorite() ? 'disabled' : '' }}>{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>
                    </form>  --}}
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea v-model="body" class="form-control"></textarea>
                </div>
                <button @click="update" class="btn btn-primary btn-xs">Submit</button>
                <button @click="editing = false" class="btn btn-link">Cancel</button>
            </div>
            <div v-else>
                <div class="body" v-text="body"></div>
            </div>
        </div>
        @can('delete', $reply)
        <div class="panel-footer level">
            <button class="btn" @click="editing = true">Edit</button>
            <button @click="destroy" style="color:red;" class="btn">Delete</button>
        </div>
        @endcan
    </div>
</reply>