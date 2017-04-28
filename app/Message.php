<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    /**
     * The fields to be appended when fetching the model.
     *
     * @var array
     */
    protected $appends = ['author'];

    /**
     * Return the author.
     *
     * @return Model
     */
    public function getAuthorAttribute()
    {
        return $this->messageable;
    }

    /**
     * Scope the message from the given model.
     *
     * @return Builder
     */
    public function scopeFrom(Builder $query, $model)
    {
        return $query
            ->where('messageable_type', get_class($model))
            ->where('messageable_id', $model->id);
    }

    /**
     * Scope the message from the given model.
     *
     * @return Builder
     */
    public function scopeTo(Builder $query, $model)
    {
        return $query
            ->where('conversation_type', get_class($model))
            ->where('conversation_id', $model->id);
    }

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