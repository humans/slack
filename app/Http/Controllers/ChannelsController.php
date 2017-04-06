<?php

namespace App\Http\Controllers;

use App\Channel;

class ChannelsController extends Controller
{
    public function index()
    {
        return Channel::all();
    }

    public function show($channel)
    {
        return Channel::with('latestMessages', 'latestMessages.user')->find($channel);
    }
}