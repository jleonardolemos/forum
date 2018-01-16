<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory(\App\Thread::class)->create();
    }


    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = create(\App\Thread::class);

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $response = $this->get($this->thread->route);

        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }


    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create(\App\Reply::class, ['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->route);

        $response->assertSee(
            $reply->owner->name . ' said ' . $reply->created_at->diffForHumans()
        )->assertSee($reply->body);
    }
}
