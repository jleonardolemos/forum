@component('users.activities.activity')
@slot('header')
{{ $profileUser->name }} created: 
<a href="{{ $activity->subject->route }}">
    {{ $activity->subject->title }}
</a> at {{ $activity->subject->created_at->diffForHumans() }}
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
