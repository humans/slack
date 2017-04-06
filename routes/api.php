<?php

Route::domain('{team}.' . env('APP_DOMAIN'))->group(function () {
    Route::middleware('auth:api')->resource('channels', 'ChannelsController');
    Route::middleware('auth:api')->resource('channels.messages', 'ChannelMessagesController');
});