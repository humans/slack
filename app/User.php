<?php

namespace App;

use App\Events\UserRegistered;
use App\Events\MessageSent;
use App\Events\ChannelJoined;
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

        static::created(function (self $user) {
            $user->configure();

            event(new UserRegistered($user));
        });
    }

    /**
     * Send a message in the channel.
     *
     * @param  Channel  $channel
     * @param  string  $message
     * @return Message
     */
    public function sendMessage(Channel $channel, $message)
    {
        return tap($this->send($channel, $message, 'message'), function ($message) {
            broadcast(new MessageSent($message))->toOthers();
        });
    }

    /**
     * Send an info message to the channel.
     *
     * @param  Channel  $channel
     * @param  string  $message
     * @return Message
     */
    public function sendInfo(Channel $channel, $message)
    {
        return tap($this->send($channel, $message, 'info'), function ($message) {
            broadcast(new MessageSent($message));
        });
    }

    /**
     * Send a message to the channel.
     *
     * @param  Channel  $channel
     * @param  string  $message
     * @param  string  $type
     * @return Message
     */
    private function send(Channel $channel, $message, $type)
    {
        $message = new Message([
            'content' => $message,
            'type' => $type,
        ]);

        $message->conversation()->associate($channel);

        $message = $this->messages()->save($message)->load('user');

        return $message;
    }

    /**
     * Join a channel.
     *
     * @param  Channel  $channel
     * @return void
     */
    public function joinChannel(Channel $channel)
    {
        $this->channels()->attach($channel);

        $channel->joined = true;

        event(new ChannelJoined($channel, $this));

        return $channel;
    }

    /**
     * Set up the user's configuration.
     *
     * @return void
     */
    public function configure()
    {
        $this->team->defaultChannels()->each(function ($channel) {
            $this->joinChannel($channel);
        });

        $settings = new UserSettings;

        if ($channel = $this->team->channels()->first()) {
            $settings->conversation()->associate($channel);
        }

        $this->settings()->save($settings);
    }

    /**
     * Return all the available channels.
     *
     * @return \Illuminate\Support\Collection
     */
    public function availableChannels()
    {
        $channels = $this->channels->mark('joined', true);

        return $channels->merge(
            $this->remainingChannels($channels)
        )->sortBy('name')->values();
    }

    /**
     * Return all the public channels we haven't joined in yet.
     *
     * @param  \Illuminate\Support\Collection  $channels
     * @return Collection
     */
    private function remainingChannels($channels)
    {
        return $this->team
            ->publicChannels()
            ->except($channels)
            ->get()
            ->mark('joined', false);
    }

    /**
     * REturn the channel with the given id and add the user access on it.
     *
     * @param  string  $id
     * @return Channel
     */
    public function channel($id)
    {
        return $this->availableChannels()
            ->where('id', $id)
            ->first()
            ->load('latestMessages', 'latestMessages.user');
    }

    /**
     * Return the conversation the user.
     *
     * @param  string  $username
     * @return Collection
     */
    public function conversation($username)
    {
        $user = $this->team->user($username);

        return $this->sent($user)
            ->merge($this->received($user))
            ->sortByDesc('created_at');
    }

    /**
     * Return the messages sent to the user.
     *
     * @param  User  $user
     * @return Collection
     */
    private function sent(User $user)
    {
        return $this->messages()->with('user')->to($user)->get();
    }

    /**
     * Return the msseages received from the user.
     *
     * @param  User  $user
     * @return Collection
     */
    private function received($user)
    {
        return $this->conversations()->with('user')->from($user)->get();
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
     * It has many messages with users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->morphMany(Message::class, 'conversation');
    }

    /**
     * It has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
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
        return $this->belongsToMany(Channel::class)->orderBy('name');
    }

    /**
     * Return all the public channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publicChannels()
    {
        return $this->belongsToMany(Channel::class)->public()->orderBy('name');
    }
}
