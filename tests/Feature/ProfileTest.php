<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(\App\User::class);
        $this->get(route('users.show', $user->name))
            ->assertSee($user->name);
    }

    /** @test */
    public function a_user_has_many_threads_in_your_profile()
    {
        $user = create(\App\User::class);
        $thread1 = create(\App\Thread::class, ['user_id' => $user->id]);
        $thread2 = create(\App\Thread::class, ['user_id' => $user->id]);
        $thread3 = create(\App\Thread::class);

        $this->get(route('users.show', $user->name))
            ->assertSee($thread1->title)
            ->assertSee($thread2->title)
            ->assertDontSee($thread3->title);
    }
}
