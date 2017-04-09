<?php

namespace Tests\Unit;

use App\Team;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    function register_a_user_under_the_team()
    {
        Event::fake();

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

        $this->assertTrue($team->channels->contains(function ($channel) {
            return $channel->name === 'projects';
        }));
    }

    /** @test **/
    function return_the_channel_from_the_team()
    {
        $team = factory(Team::class)->create();

        $team->addChannel(['name' => 'projects']);

        $channel = $team->channel('projects');

        $this->assertEquals('projects', $channel->name);
    }

    /** @test **/
    function create_general_and_random_as_the_default_channels()
    {
        $team = factory(Team::class)->create();

        $this->assertTrue($team->channels->contains(function ($channel) {
            return $channel->name === 'general';
        }));

        $this->assertTrue($team->channels->contains(function ($channel) {
            return $channel->name === 'random';
        }));
    }

    /** @test **/
    function return_the_default_channels_the_user_will_be_registered_to()
    {
        $team = factory(Team::class)->create();

        $channels = $team->defaultChannels();

        $this->assertTrue($channels->contains(function ($channel) {
            return $channel->name === 'general';
        }));

        $this->assertTrue($channels->contains(function ($channel) {
            return $channel->name === 'random';
        }));
    }

    /** @test **/
    function find_by_the_slug()
    {
        factory(Team::class)->create([
            'name' => 'Artisan.ph',
            'slug' => 'artisanph',
        ]);

        $this->assertEquals('artisanph', Team::bySlug('artisanph')->slug);
    }
}
