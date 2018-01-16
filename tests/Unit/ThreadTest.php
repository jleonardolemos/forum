<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Collection;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create(\App\Reply::class)->thread;
    }

    /** @test*/
    public function it_has_a_route_attribute()
    {
        $thread = create(\App\Thread::class);
        $this->assertEquals(
            $thread->route,
            route('threads.show', [
                'channel' => $thread->channel->slug,
                'thread' => $thread->id
            ])
        );
    }

    /** @test*/
    public function it_belongs_to_a_user_called_creator()
    {
        $this->assertInstanceOf(\App\user::class, $this->thread->creator);
    }

    /** @test*/
    public function it_has_many_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test*/
    public function it_can_create_replies()
    {
        $reply = make(\App\Reply::class);
        $this->thread->reply($reply->toArray());

        $this->assertEquals(
            $this->thread->replies()->get()->last()->body,
            $reply->body
        );
    }

    /** @test*/
    public function it_belongs_to_a_channel()
    {
        $thread = create(\App\Thread::class);
        $this->assertInstanceOf(\App\Channel::class, $thread->channel);
    }
}
