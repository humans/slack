<?php

namespace App;

class Channel extends Model
{
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessages()
    {
        return $this->hasMany(Message::class)->limit(5);
    }

    /**
     * It has and belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}