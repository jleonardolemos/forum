<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Favorite;

class favoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @teste*/
    public function it_belongs_to_an_user()
    {
        $this->signIn($user = create(\App\User::class));
        $reply = create(\App\Reply::class);
        $reply->favorite();
        $this->assertEquals(
            $reply->favorites()->first()->user->toArray(),
            $user->toArray()
        );
    }

    /** @teste*/
    public function it_belongs_to_a_favoriteable()
    {
        $this->signIn();
        $reply = create(\App\Reply::class);
        $reply->favorite();
        $this->assertEquals(
            Favorite::first()->favorited->id,
            $reply->id
        );
    }
}
