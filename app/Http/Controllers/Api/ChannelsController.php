<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use Illuminate\Http\Request;
use App\Http\Requests\CreateChannelRequest;

class ChannelsController extends Controller
{
    /**
     * Return all the public channels and all the private channels 
     * the user belongs to.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Team $team)
    {
        return $request->user()->channels;
    }

    /**
     * Return the channel information.
     *
     * @param  Team  $team
     * @return Channel
     */
    public function show(Team $team, $channel)
    {
        return Channel::with('latestMessages', 'latestMessages.user')->find($channel);
    }

    /**
     * Create a new channel under the team.
     *
     * @param  CreateChannelRequest  $request
     * @param  Team  $team
     * @return Channel
     */
    public function store(CreateChannelRequest $request, Team $team)
    {
        $channel = $team->addChannel($request->only('name', 'description'));

        $channel->addUser($request->user());

        return $channel;
    }
}