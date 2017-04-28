<?php

namespace App\Http\Controllers\Api;

use App\Team;
use App\Channel;
use Illuminate\Http\Request;

class ConversationMessagesController extends Controller
{
    /**
     * Send the message in the channel.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  string  $type
     * @param  int  $id
     * @return Message
     */
    public function store(Request $request, Team $team, $type, $id)
    {
        return $request->user()
            ->sendMessage($this->find($type, $id), $request->message);
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