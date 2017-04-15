<?php

Route::middleware('auth:api')->domain('{team}.' . env('APP_DOMAIN'))->group(function () {
    Route::patch('user/settings/active_channel/{channel}', 'UpdateUserActiveChannelController')->name('user.settings.active_channel');

    Route::get('team', 'TeamDetailsController')->name('team.details');
    Route::get('me', 'CurrentUserController')->name('me');

    Route::resource('users', 'UsersController', [
        'only' => ['index']
    ]);

    Route::post('channels/{channel}/join', 'JoinChannelController')->name('channels.join');

    Route::resource('channels', 'ChannelsController', [
        'only' => ['index', 'show', 'store']
    ]);

    Route::resource('available_channels', 'AvailableChannelsController', [
        'only' => ['index']
    ]);

    Route::resource('channels.messages', 'ChannelMessagesController', [
        'only' => ['store']
    ]);
});