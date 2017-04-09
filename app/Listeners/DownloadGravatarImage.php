<?php

namespace App\Listeners;

use App\Http\Gravatar;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadGravatarImage
{
    /**
     * Gravatar downloader.
     *
     * @var Gravatar
     */
    protected $gravatar;

    /**
     * Create the event listener.
     *
     * @param  Gravatar  $gravatar
     * @return void
     */
    public function __construct(Gravatar $gravatar)
    {
        $this->gravatar = $gravatar;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user->fresh();

        $user->update([
            'avatar' => $this->gravatar->email($user->email)->download()
        ]);
    }
}
