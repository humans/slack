<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Disable mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        static::saving(function (self $user) {
            if ($user->isDirty('password')) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    /**
     * Send a message in the channel.
     *
     * @param  Channel  $channel
     * @param  string  $message
     * @return Message
     */
    public function sendMessage(Channel $channel, string $message)
    {
        $message = new Message(['content' => $message]);

        $message->channel()->associate($channel);

        return $this->messages()->save($message)->load('user');
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
}
