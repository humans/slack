<?php

namespace Tests\Unit;

use App\Channel;
use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Event::fake();
    }

    /** @test **/
    function send_a_message_to_a_channel()
    {
        $team = factory(\App\Team::class)->create();

        $channel = $team->addChannel(['name' => 'projects']);

        $user = $team->addUser([
            'username' => 'jaggy',
            'email' => 'jaggygauran@gmail.com',
            'password' => '123456',
        ]);

        $user->sendMessage($channel, 'Hello World!');

        $this->assertCount(1, \App\Message::all());
    }

    /** @test **/
    function create_some_settings_when_the_user_is_created()
    {
        $user = factory(User::class)->create();

        $user->configure();

        $this->assertCount(1, \App\UserSettings::all());
    }

    /** @test **/
    function join_in_general_and_random_after_registering()
    {
        $team = factory(Team::class)->create();

        $team->addChannel(['name' => 'general']);
        $team->addChannel(['name' => 'random']);

        $user = factory(User::class)->create(['team_id' => $team->id]);

        $user->configure();

        $this->assertTrue($user->channels->contains(function ($channel) {
            return $channel->name === 'general';
        }));

        $this->assertTrue($user->channels->contains(function ($channel) {
            return $channel->name === 'random';
        }));
    }

    /** @test **/
    function set_the_latest_channel_accessed_as_general_when_the_user_is_new()
    {
        $team = factory(Team::class)->create();

        $team->addChannel(['name' => 'general']);

        $user = factory(User::class)->create(['team_id' => $team->id]);

        $user->configure();

        $this->assertEquals('general', $user->fresh()->settings->activeChannel->name);
    }

    /** @test **/
    function join_a_channel()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create(['team_id' => $team->id]);

        $general = factory(Channel::class)->create([
            'name' => 'general',
            'team_id' => $team->id,
        ]);

        $user->joinChannel($general);

        $this->assertTrue($user->fresh()->channels->contains(function ($channel) {
            return $channel->name === 'general';
        }));
    }
}
