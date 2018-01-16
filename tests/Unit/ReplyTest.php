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
}
