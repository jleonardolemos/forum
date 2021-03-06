@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <h4 class="flex"><a href="{{ $thread->route }}">{{ $thread->title }}</a></h4>
                        <a href="{{ $thread->route }}">{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}</a>
                    </div>
                </div>

                <div class="panel-body">
                    <article>
                        <div class="body">{{ $thread->body }}</div>
                    </article>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
