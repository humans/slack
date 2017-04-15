<?php

namespace App;

use App\Events\ChannelJoined;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
    /**
     * The user's status in the channel.
     *
     * @var bool
     */
    public $joined = false;

    /**
     * Fields to append to serialization.
     *
     * @var array
     */
    protected $appends = ['joined'];

    /**
     * Return if the user querying this joined the channel.
     *
     * @return bool
     */
    public function getJoinedAttribute()
    {
        return $this->joined;
    }

    /**
     * Return all the public channels.
     *
     * @param  Builder  $builder
     * @return Builder
     */
    public function scopePublic(Builder $query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Return all the private channels.
     *
     * @param  Builder  $builder
     * @return Builder
     */
    public function scopePrivate(Builder $query)
    {
        return $query->where('is_private', true);
    }

    /**
     * Return all the channels except the specified items.
     *
     * @param  Builder  $query
     * @param  Collection|array  $channels
     * @return Builder
     */
    public function scopeExcept(Builder $query, $channels)
    {
        if ($channels instanceof Collection) {
            $channels = $channels->pluck('id');
        }

        return $query->whereNotIn('id', $channels);
    }

    /**
     * Add a user to the channel.
     *
     * @return void
     */
    public function addUser(User $user)
    {
        $this->users()->attach($user);

        event(new ChannelJoined($this, $user));
    }

    /**
     * Mark the channel as joined.
     *
     * @return Channel
     */
    public function join()
    {
        $this->joined = true;

        return $this;
    }

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
        return $this->hasMany(Message::class)->limit(20)->orderBy('created_at', 'DESC');
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