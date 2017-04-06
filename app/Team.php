<?php

namespace App;

class Team extends Model
{
    /**
     * Register the user under the team.
     *
     * @param  array  $attributes
     * @return User
     */
    public function addUser(array $attributes)
    {
        return $this->users()->save(new User($attributes));
    }

    /**
     * The key for routing.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * It has many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * It has many channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}