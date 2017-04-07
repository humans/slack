<?php

namespace App;

class UserSettings extends Model
{
    /**
     * It belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * It belongs to a channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activeChannel()
    {
        return $this->belongsTo(Channel::class, 'active_channel_id');
    }
}