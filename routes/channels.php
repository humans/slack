<?php

use App\Team;

Broadcast::channel('{team}.channel.{channel}', function ($user, Team $team, $channel) {
    return true;
});