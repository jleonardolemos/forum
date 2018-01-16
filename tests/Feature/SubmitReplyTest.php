<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Auth\AuthenticationException;

class SubmitReplyTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_cant_submit_a_reply()
    {
        $thread = create(\App\Thread::class);
        $this->expectException(AuthenticationException::class);
        $this->post(route('threads.replies.store', [
            'channel' => $thread->channel->slug,
            'thread' => $thread->id
        ]), []);
    }

    /** @test */
    public function an_authenticated_user_can_submit_a_reply()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class);

        $this->post(
            route('threads.replies.store', [
                'channel' => $thread->channel->slug,
                'thread' => $thread->id
            ]),
            $reply->toArray()
        );
        $reponse = $this->get($thread->route);

        $reponse->assertSee($reply->body);
    }
}
