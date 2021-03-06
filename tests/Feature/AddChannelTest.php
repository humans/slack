<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Team;
use App\Channel;
use App\User;
use App\Events\ChannelCreated;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddChannelTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        Event::fake();
    }

    /** @test **/
    function add_a_new_channel_and_broadcast_the_event()
    {
        $team = factory(Team::class)->create();

        Passport::actingAs(
            factory(User::class)->create(['team_id' => $team->id]),
            ['create-channel']
        );

        $this->assertFalse(Channel::whereName('projects')->exists());

        $this->instance(Team::class, $team);

        $response = $this->post(route('channels.store', $team), [
            'name' => 'projects',
        ]);

        Event::assertDispatched(ChannelCreated::class, function ($event) {
            return $event->channel->name = 'projects';
        });

        $response->assertStatus(200);
    }

    /** @test **/
    function channel_name_is_unique()
    {
        $team = factory(Team::class)->create();
        $channel = factory(Channel::class)->create([
            'name' => 'projects',
            'team_id' => $team->id,
        ]);

        $this->assertCount(1, $team->channels);

        $response = $this->json('POST', route('channels.store', $team), [
            'name' => 'projects',
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            '"projects" is already taken by a channel, username, or user group.'
        ]);

        $this->assertCount(1, $team->channels);
    }
}
