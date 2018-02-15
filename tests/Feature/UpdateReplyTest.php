<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_unauthorized_user_can_not_update_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create(\App\Reply::class);
        $body = 'New body';
        $this->performPatchRequestOnReply($reply, $body)->assertRedirect(route('login'));
        $this->signIn();
        $this->performPatchRequestOnReply($reply, $body)->assertStatus(403);
    }

    /** @test */
    public function a_authorized_user_can_update_a_reply()
    {
        $reply = create(\App\Reply::class);
        $this->signIn($reply->owner);
        $body = 'New body';
        $this->performPatchRequestOnReply($reply, $body);
        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => 'New body'
        ]);
    }

    private function performPatchRequestOnReply($reply, $body)
    {
        return $this->patch(route('threads.replies.update', $reply->id), [
            'body' => $body
        ]);
    }
}
