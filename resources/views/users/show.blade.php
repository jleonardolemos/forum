@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                    <small>{{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>
            </div>
            @foreach($dates as $date => $activities)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activities as $activity)
                @include('users.activities.' . $activity->type)
                @endforeach 
            @endforeach 
            {{--  {{ $threads->links() }}  --}}
        </div>
    </div>
</div>
@endsection