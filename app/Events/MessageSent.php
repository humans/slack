<?php

namespace App\Events;

use App\Team;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $team;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  Team  $team
     * @param  Message  $message
     * @return MessageSent
     */
    public function __construct(Team $team, Message $message)
    {
        $this->team = $team;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $this->message->load('user', 'channel');

        return new PrivateChannel($this->team->slug . '.channel.' . $this->message->channel->name);
    }
}
