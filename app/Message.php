<?php

namespace App;

class Message extends Model
{
    /**
     * It belongs to a user or a bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function user()
    {
        return $this->morphTo('messageable');
    }

    /**
     * It belongs to a channel or a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function conversation()
    {
        return $this->morphTo('conversation');
    }
}