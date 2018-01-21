<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_can_not_favorite_a_reply()
    {
        $reply = create(\App\Reply::class);
        $this->withExceptionHandling()
            ->post(route('replies.favorite', $reply->id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_authenticated_user_can_favorite_a_reply_once()
    {
        $reply = create(\App\Reply::class);
        $this->signIn();

        $this->post(route('replies.favorite', $reply->id));
        $this->post(route('replies.favorite', $reply->id));

        $this->assertEquals($reply->favorites()->count(), 1);
    }
}
