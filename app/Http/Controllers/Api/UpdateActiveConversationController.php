<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use Illuminate\Http\Request;

class UpdateActiveConversationController extends Controller
{
    /**
     * Update the user's active channel.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  Channel  $channel
     * @return \App\UserSettings
     */
    public function __invoke(Request $request, Team $team, $type, $id)
    {
        $settings = $request->user()->settings;

        // Refactor this into a method.
        $settings->conversation()->associate($this->find($type, $id));
        $settings->save();

        return ['response' => true];
    }

    /**
     * Return the model we'll use.
     *
     * @param  string  $type
     * @return \App\Model
     */
    private function model($type)
    {
        if ($type === 'channel') {
            return app(\App\Channel::class);
        }

        return app(\App\User::class);
    }

    /**
     * Find the model from the id.
     *
     * @param  string  $type
     * @param  int  $id
     * @return \App\Model
     */
    private function find($type, $id)
    {
        return $this->model($type)->find($id);
    }
}