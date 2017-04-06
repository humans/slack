<?php

namespace App\Http\Controllers;

use App\Team;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChannelMessagesController extends Controller
{
    /**
     * Store the message.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  string  $channel
     * @return Message
     */
    public function store(Request $request, Team $team, $channel)
    {
        $message = $request->user()->sendMessage(
            $team->channel($channel),
            $request->message
        );

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }
}