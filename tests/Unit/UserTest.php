<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function it_has_a_slug_identifier()
    {
        $user = create(\App\User::class);
        $this->assertEquals($user->getRouteKeyName(), 'name');
    }

    /** @test*/
    public function it_has_many_threads()
    {
        $user = create(\App\User::class);
        $t1 = create(\App\Thread::class, ['user_id' => $user->id]);
        $t2 = create(\App\Thread::class, ['user_id' => $user->id]);
        $this->assertEquals($user->threads->first()->title, $t1->title);
        $this->assertEquals($user->threads->last()->title, $t2->title);
    }

    /** @test*/
    public function it_has_many_activities()
    {
        $this->signIn($user = create(\App\User::class));
        create(\App\Reply::class, ['user_id' => $user->id]);
        $this->assertEquals($user->activities()->count(), 2);
    }
}
