<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

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

        $this->assertCount(1, \App\UserSettings::all());
    }

    /** @test **/
    function join_in_general_and_random_after_registering()
    {
        $user = factory(User::class)->create();

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
        $user = factory(User::class)->create();

        factory(\App\Channel::class)->create([
            'name' => 'projects',
            'team_id' => $user->team->id,
        ]);

        // $this->assertEquals('projects', $user->settings->activeChannel->name);
    }
}
