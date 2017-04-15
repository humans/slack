<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use Illuminate\Http\Request;

class UpdateUserActiveChannelController extends Controller
{
    /**
     * Update the user's active channel.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  Channel  $channel
     * @return \App\UserSettings
     */
    public function __invoke(Request $request, Team $team, Channel $channel)
    {
        $settings = $request->user()->settings;

        $settings->conversation()->associate($channel);
        $settings->save();

        return ['response' => true];
    }
}