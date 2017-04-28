<?php

namespace App\Listeners;

use App\Events\ChannelJoined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInformationMessage
{
    /**
     * Create the event listener.
     *
     * @return SendInformationMessage
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ChannelJoined  $event
     * @return void
     */
    public function handle(ChannelJoined $event)
    {
        [$user, $channel] = [$event->user, $event->channel];

        $user->sendInfo($channel, "joined #{$event->channel->name}");
    }
}
