<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use Illuminate\Http\Request;

class ChannelMessagesController extends Controller
{
    /**
     * Send the message in the channel.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  int  $channel
     * @return Message
     */
    public function store(Request $request, Team $team, $channel)
    {
        return $request->user()
            ->sendMessage(Channel::find($channel), $request->message);
    }
}