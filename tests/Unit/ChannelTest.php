<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Team;
use App\User;
use App\Channel;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    function add_a_user_to_the_channel()
    {
        Event::fake();

        $user = factory(User::class)->create([
            'username' => 'jaggy'
        ]);

        $channel = factory(Channel::class)->create([
            'team_id' => $user->team->id,
        ]);

        $this->assertCount(0, $channel->users);

        $channel->addUser($user);

        $this->assertTrue($channel->users()->get()->contains(function ($user) {
            return $user->username === 'jaggy';
        }));
    }

    /** @test **/
    function return_all_the_public_channels()
    {
        Event::fake();

        $team = factory(Team::class)->create();

        factory(Channel::class)->times(2)->create(['team_id' => $team->id]);
        factory(Channel::class)->states('private')->create(['team_id' => $team->id]);

        $this->assertCount(2, Channel::public()->get());
    }
}
