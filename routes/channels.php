<?php

use App\Team;

Broadcast::channel('{team}.conversation.{conversation}', function ($user, Team $team, $conversation) {
    return true;
});

Broadcast::channel('{team}.channel', function ($user, Team $team) {
    return true;
});