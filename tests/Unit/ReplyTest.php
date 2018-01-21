<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{

    use DatabaseMigrations;

    protected $reply;

    public function setUp()
    {
        parent::setUp();
        $this->reply = create(\App\Reply::class);
    }

    /** @teste*/
    public function it_has_a_owner()
    {
        $this->assertInstanceOf(\App\User::class, $this->reply->owner);
    }

    /** @teste*/
    public function it_has_a_thread()
    {
        $this->assertInstanceOf(\App\Thread::class, $this->reply->thread);
    }

    /** @teste*/
    public function it_has_many_favorits()
    {
        $user1 = create(\App\User::class);
        $user2 = create(\App\User::class);
        $reply = create(\App\Reply::class);

        $this->signIn($user1);
        $reply->favorite();
        $this->signIn($user2);
        $reply->favorite();

        $this->assertEquals($reply->favorites()->count(), 2);
    }

    /** @teste*/
    public function it_can_check_for_favorites()
    {
        $user1 = create(\App\User::class);
        $user2 = create(\App\User::class);
        $reply = create(\App\Reply::class);

        $this->signIn($user1);
        $reply->favorite();
        $this->assertTrue($reply->IsFavorite());
        $this->signIn($user2);
        $this->assertFalse($reply->IsFavorite());
    }
}
