<?php

Route::middleware('auth:api')->resource('channels', 'ChannelsController');
Route::middleware('auth:api')->resource('channels.messages', 'MessagesController');