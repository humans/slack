<?php

namespace App\Events;

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

    /**
     * The message we'll broadcast to those conencted.
     *
     * @var Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  Message  $message
     * @return MessageSent
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // We have to load this so serialization will work.
        $this->message->load('user', 'conversation');

        return new PrivateChannel(
            $this->message->messageable->team->slug . '.channel.' . $this->message->conversation->name
        );
    }
}
