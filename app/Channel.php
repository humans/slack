<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
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