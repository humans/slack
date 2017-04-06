<?php

namespace Tests\Unit;

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
}
