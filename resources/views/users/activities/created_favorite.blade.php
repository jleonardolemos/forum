@component('users.activities.activity')
@slot('header')
<a href="{{ route('users.show', $activity->subject->user->name) }}"> {{ $activity->subject->user->name }} </a> favorited a reply
@endslot

@slot('body')
{{ $activity->subject->favorited->body }}
@endslot
@endcomponent
