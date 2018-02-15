<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_unauthorized_user_can_not_delete_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create(\App\Reply::class);
        $this->performReleteRequestOnReply($reply)->assertRedirect(route('login'));
        $this->signIn();
        $this->performReleteRequestOnReply($reply)->assertStatus(403);
    }

    private function performReleteRequestOnReply($reply)
    {
        return $this->delete(route('threads.replies.delete', [
            'channel' => $reply->thread->channel->slug,
            'thread' => $reply->thread->id,
            'reply' => $reply->id,
        ]));
    }

    /** @test */
    public function a_authorized_user_can_delete_a_reply()
    {
        $reply = create(\App\Reply::class);
        $this->signIn($reply->owner);
        $this->performReleteRequestOnReply($reply);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
