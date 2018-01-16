<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Auth\AuthenticationException;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test*/
    public function an_unauthenticated_user_cant_submit_a_thread()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));
    }

    /** @test*/
    public function an_authenticated_user_can_submit_a_thread()
    {
        $this->signIn();
        $thread = make(\App\Thread::class);
        
        $response = $this->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))->assertSee($thread->body);
    }

    /** @test*/
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test*/
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test*/
    public function a_thread_requires_a_valid_channel()
    {
        factory(\App\Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 69])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(\App\Thread::class, $overrides);
        return $this->post(route('threads.store'), $overrides);
    }
}
