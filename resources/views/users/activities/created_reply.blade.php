@component('users.activities.activity')
@slot('header')
{{ $profileUser->name }} replied:
<a href="{{ $activity->subject->thread->route }}">
    {{ $activity->subject->thread->title }}
</a> at {{ $activity->subject->created_at->diffForHumans() }}
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
