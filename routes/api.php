<?php

Route::middleware('auth:api')->domain('{team}.' . env('APP_DOMAIN'))->group(function () {
    Route::get('user/settings', 'UserSettingsController')->name('user.settings');
    Route::patch('user/settings/active_channel/{channel}', 'UpdateUserActiveChannelController')->name('user.settings.active_channel');

    Route::resource('channels', 'ChannelsController');
    Route::resource('channels.messages', 'ChannelMessagesController');
});