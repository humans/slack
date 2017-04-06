<?php

namespace App\Http\Controllers;

use App\Message;
use App\Channel;
use App\Events\MessageSent;
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
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]));

        broadcast(new MessageSent($message))->toOthers();

        return $message->load('user');
    }
}