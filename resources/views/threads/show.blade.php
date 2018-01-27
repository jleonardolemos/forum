@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ route('users.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                            {{ $thread->title }}
                        </span>

                        <form action="{{ route('threads.delete', [
                            'channel' => $thread->channel->slug,
                            'thread' => $thread->id,
                        ]) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>

            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {!! $replies->links() !!}

            @if(auth()->check())
            <form action="{{ route('threads.replies.store', ['channel' => $thread->channel->slug, 'thread' => $thread->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" name="body" id="body" placeholder="Have some shit to say?" rows="5" required></textarea>
                </div>

                <button class="btn btn-info">Send</button>
            </form>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to contribute </p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="{{ route('users.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a>,
                        and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
