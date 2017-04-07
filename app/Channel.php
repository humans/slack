<?php

namespace App;

class Channel extends Model
{
    /**
     * It has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Return the 5 latest messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    /**
     * It belongs to a team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}