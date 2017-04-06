<?php

namespace App\Http\Controllers;

use App\Team;
use App\Channel;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChannelMessagesController extends Controller
{
    /**
     * Store the message.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  int  $channel
     * @return Message
     */
    public function store(Request $request, Team $team, $channel)
    {
        $message = $request->user()->sendMessage(
            Channel::find($channel),
            $request->message
        );

        broadcast(new MessageSent($team, $message))->toOthers();

        return $message;
    }
}