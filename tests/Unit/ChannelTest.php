<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function it_has_many_threads()
    {
        $channel = create(\App\Channel::class);
        $thread = create(\App\Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }

    /** @test*/
    public function it_has_a_slug_identifier()
    {
        $channel = create(\App\Channel::class);
        $this->assertEquals($channel->getRouteKeyName(), 'slug');
    }
}
