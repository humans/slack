<?php

namespace App\Events;

use App\User;
use App\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelJoined
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Channel the user just joined.
     *
     * @var Channel
     */
    public $channel;

    /**
     * The user that joined the channel.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  Channel  $channel
     * @param  User  $user
     * @return ChannelJoined
     */
    public function __construct(Channel $channel, User $user)
    {
        $this->channel = $channel;
        $this->user = $user;
    }
}
