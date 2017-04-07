<?php

namespace App;

class Team extends Model
{
    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        static::created(function (self $team) {
            $team->configureDefaultChannels();
        });
    }

    /**
     * Configure the default channels.
     *
     * @return void
     */
    public function configureDefaultChannels()
    {
        $this->channels()->saveMany([
            new Channel(['name' => 'general']),
            new Channel(['name' => 'random']),
        ]);
    }

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
     * Add a channel under the team.
     *
     * @param  array  $attributes
     * @return Channel
     */
    public function addChannel(array $attributes)
    {
        return $this->channels()->save(new Channel($attributes));
    }

    /**
     * Return the channel from the name.
     *
     * @param  string  $name
     * @return Channel
     */
    public function channel(string $name)
    {
        return $this->channels()->whereName($name)->first();
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