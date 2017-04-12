<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Events\UserRegistered;
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
    public function sendMessage(Channel $channel, string $message)
    {
        $message = new Message(['content' => $message]);

        $message->channel()->associate($channel);

        $message = $this->messages()->save($message)->load('user');

        broadcast(new MessageSent($message))->toOthers();

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

        return $channel;
    }

    /**
     * Set up the user's configuration.
     *
     * @return void
     */
    public function configure()
    {
        $this->channels()->attach($this->team->defaultChannels());

        $settings = new UserSettings;

        $settings->activeChannel()->associate($this->team->channels()->first());

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
