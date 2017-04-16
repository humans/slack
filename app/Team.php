<?php

namespace App;

use App\Events\ChannelCreated; use Illuminate\Database\Eloquent\Builder;

class Team extends Model
{
    /**
     * The channels to be created when a new team is made.
     *
     * @var array
     */
    protected $defaultChannels = ['general', 'random'];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        static::created(function (self $team) {
            $team->configure();
        });
    }

    /**
     * Find the team by the slug.
     *
     * @param  Builder  $query
     * @param  string  $slug
     * @return Builder
     */
    public function scopeBySlug(Builder $query, $slug)
    {
        return $query->whereSlug($slug)->first();
    }

    /**
     * Configure the team channels.
     *
     * @return void
     */
    public function configure()
    {
        $channels = array_map(function ($channel) {
            return new Channel(['name' => $channel]);
        }, $this->defaultChannels);

        $this->channels()->saveMany($channels);
    }

    /**
     * The default channels we'll register the user into.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function defaultChannels()
    {
        return $this->channels()->whereIn('name', $this->defaultChannels)->get();
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
        $channel = $this->channels()->save(new Channel($attributes));

        broadcast(new ChannelCreated($channel))->toOthers();

        return $channel;
    }

    /**
     * Return the user from the username.
     *
     * @param  string  $username
     * @return User
     */
    public function user($username)
    {
        return $this->users()->whereUsername($username)->first();
    }

    /**
     * Return the channel from the name.
     *
     * @param  string  $name
     * @return Channel
     */
    public function channel($name)
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
        return $this->hasMany(User::class)->orderBy('username');
    }

    /**
     * It has many channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasMany(Channel::class)->orderBy('name', 'ASC');
    }

    /**
     * It has many public channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicChannels()
    {
        return $this->hasMany(Channel::class)->public()->orderBy('name');
    }
}