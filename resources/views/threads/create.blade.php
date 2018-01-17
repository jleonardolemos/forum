@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new Thread</div>
                <div class="panel-body">
                    <form action="{{ route('threads.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="channel_id">Channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control">
                                <option value="">Pick a channel...</option>
                                @foreach(App\Channel::get() as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" rows="8" class="form-control">{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Publish</button>
                        </div>
                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li style="margin-left:10px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
