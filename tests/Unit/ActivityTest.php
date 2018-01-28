<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function it_records_a_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->user()->id,
            'subject_id' => $thread->id,
            'subject_type' => \App\Thread::class,
        ]);

        $activity = \App\Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test*/
    public function it_records_a_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(\App\Reply::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->user()->id,
            'subject_id' => $reply->id,
            'subject_type' => \App\Reply::class,
        ]);

        $this->assertEquals(\App\Activity::count(), 2);
    }
}
