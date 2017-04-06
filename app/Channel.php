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
}