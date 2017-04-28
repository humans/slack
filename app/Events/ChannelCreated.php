<?php

namespace App\Events;

use App\Team;
use App\Channel as EloquentChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The channel we'll broadcast to those conencted.
     *
     * @var EloquentChannel
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @param  Team  $team
     * @param  EloquentChannel  $channel
     * @return void
     */
    public function __construct(EloquentChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // There _has_ to be a better way of doing this.
        $this->channel->joined = false;

        return new PrivateChannel($this->channel->team->slug . '.channel');
    }
}
