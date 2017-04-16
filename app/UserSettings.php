<?php

namespace App;

class UserSettings extends Model
{
    /**
     * Add the fields to append to serialization.
     *
     * @var array
     */
    protected $appends = ['conversation', 'active_conversation_type'];

    /**
     * Return the type of conversation.
     *
     * @return Conversation
     */
    public function getConversationAttribute()
    {
        return $this->conversation()->first();
    }

    /**
     * Return the active conversation type.
     *
     * @param  string  $type
     * @return string
     */
    public function getActiveConversationTypeAttribute()
    {
        return strtolower(class_basename($this->conversation_type));
    }

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
     * It belongs to a channel or a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function conversation()
    {
        return $this->morphTo();
    }
}