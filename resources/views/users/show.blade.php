@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-header">
        {{ $profileUser->name }}
        <small>{{ $profileUser->created_at->diffForHumans() }}</small>
    </div>
    @foreach($threads as $thread)
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <span class="flex">
                    <a href="{{ route('users.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                    {{ $thread->title }}
                </span>
                <span>{{ $thread->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="panel-body">
            {{ $thread->body }}
        </div>
    </div>
    @endforeach
    {{ $threads->links() }}
</div>
@endsection