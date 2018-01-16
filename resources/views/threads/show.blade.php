@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Thread - {{ $thread->title }}</div>
                <div class="panel-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
    </div>

    @foreach($thread->replies as $reply)
        @include('threads.reply')
    @endforeach

    @if(auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('threads.replies.store', ['channel' => $thread->channel->slug, 'thread' => $thread->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" name="body" id="body" placeholder="Have some shit to say?" rows="5" required></textarea>
                </div>

                <button class="btn btn-info">Send</button>
            </form>
        </div>
    </div>
    @else
    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to contribute </p>
    @endif
</div>
@endsection
