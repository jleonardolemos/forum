<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageThreadsTest extends TestCase
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

        $response->assertSee('said ' . $reply->created_at->diffForHumans())
            ->assertSee($reply->owner->name)
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_user_name()
    {
        $user = create(\App\User::class);
        $threadByUser = create(\App\Thread::class, ['user_id' => $user->id]);
        $threadNotByUser = create(\App\Thread::class);

        $this->get(route('threads.index', [null, 'by' => $user->name]))
            ->assertSee($threadByUser->title)
            ->assertDontSee($threadNotByUser->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithoutReplies = $this->thread;

        $response = $this->getJson(route('threads.index', [null, 'popular' => '1']))->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_unauthorized_user_can_not_delete_threads()
    {
        $this->withExceptionHandling();
        $reply = create(\App\Reply::class);

        //GUEST TEST
        $reponse = $this->delete(route('threads.delete', [
            'channel' => $reply->thread->channel->slug,
            'thread' => $reply->thread->id,
        ]), ['id' => $reply->thread->id]);

        $reponse->assertRedirect(route('login'));
        //GUEST TEST

        //BAD USER TEST
        $this->signIn(create(\App\User::class));
        $reponse = $this->delete(route('threads.delete', [
            'channel' => $reply->thread->channel->slug,
            'thread' => $reply->thread->id,
        ]), ['id' => $reply->thread->id]);

        $reponse->assertStatus(403);
        //BAD USER TEST
    }

    /** @test */
    public function a_authorized_user_can_delete_threads()
    {
        $this->signIn();
        $thread = create(\App\Thread::class, [
            'user_id' => auth()->user()->id
        ]);
        $reply = create(\App\Reply::class, [
            'user_id' => auth()->user()->id,
            'thread_id' => $thread->id,
        ]);

        $reponse = $this->json('delete', route('threads.delete', [
            'channel' => $thread->channel->slug,
            'thread' => $thread->id,
        ]), ['id' => $thread->id]);

        $reponse->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, \App\Activity::count());
    }
}
