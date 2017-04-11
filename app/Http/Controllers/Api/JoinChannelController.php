<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Team;
use App\Channel;

class JoinChannelController extends Controller
{
    /**
     * Join the channel.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  int  $channel
     * @return Channel
     */
    public function __invoke(Request $request, Team $team, $channel)
    {
        $channel = Channel::find($channel);

        return $request->user()->joinChannel($channel);
    }
}