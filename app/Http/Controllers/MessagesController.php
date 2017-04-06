<?php

namespace App\Http\Controllers;

use App\Message;
use App\Channel;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Channel $channel)
    {
        return $channel->messages;
    }

    public function store(Request $request, Channel $channel)
    {
        $message = $channel->messages()->save(new Message([
            'content' => $request->message,
            'user_id' => $request->user()->id,
        ]));

        event(new MessageSent($channel, $message));
    }
}