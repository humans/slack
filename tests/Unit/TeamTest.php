<?php

namespace Tests\Unit;

use App\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    function register_a_user_under_the_team()
    {
        $team = factory(Team::class)->create();

        $team->addUser([
            'username' => 'jaggy',
            'password' => '123456',
            'email' => 'jaggygauran@gmail.com'
        ]);

        $this->assertCount(1, \App\User::all());
    }

    /** @test **/
    function add_channel_under_the_team()
    {
        $team = factory(Team::class)->create();

        $team->addChannel([
            'name' => 'projects',
            'description' => 'WE ACTUALLY HAVE PROJECTS',
        ]);

        $this->assertCount(1, \App\Channel::all());
    }

    /** @test **/
    function return_the_channel_from_the_team()
    {
        $team = factory(Team::class)->create();

        $team->addChannel(['name' => 'projects']);

        $channel = $team->channel('projects');

        $this->assertEquals('projects', $channel->name);
    }
}
