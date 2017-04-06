<?php

namespace App\Http\Controllers;

use App\Team;
use App\Channel;

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
}