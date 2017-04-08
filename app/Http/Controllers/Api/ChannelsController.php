<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use App\Http\Requests\CreateChannelRequest;

class ChannelsController extends Controller
{
    /**
     * Return all the channels under the team.
     *
     * @param  Team  $team
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Team $team)
    {
        return $team->channels;
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
        return $team->addChannel($request->only('name', 'description'));
    }
}