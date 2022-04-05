<?php

namespace App\Listeners;

use App\Events\UserInvited;
use App\Notifications\Invitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserInvitation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserInvited  $event
     * @return void
     */
    public function handle(UserInvited $event)
    {
        $event->user->notify(new Invitation($event->url));
    }
}
