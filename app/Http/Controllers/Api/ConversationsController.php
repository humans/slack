<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    /**
     * Return the conversation between you and the other person/bot.
     *
     * @param  Request  $request
     * @param  string  $username
     * @return \Illuminate\Support\Collection
     */
    public function show(Request $request, Team $team, $username)
    {
        return $request->user()->conversation($username);
    }
}