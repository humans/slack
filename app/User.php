<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Events\MessageSent;
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

        static::created(function (self $user) {
            $user->configure();
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

        $message = $this->messages()->save($message)->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    /**
     * Set up the user's configuration.
     *
     * @return void
     */
    public function configure()
    {
        $this->channels()->attach($this->team->defaultChannels()->pluck('id'));

        $settings = new UserSettings;

        $settings->activeChannel()->associate($this->team->channels()->first());

        $this->settings()->save($settings);
    }

    /**
     * It has settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne(UserSettings::class);
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
     * It belongs to a team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * These are all the channels the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }
}
