<?php

namespace App\Listeners;

use App\Notifications\InvitationAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAcceptedInvitation
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
     * @param  object  $event
     * @return void
     */
    public function handle(InvitationAccepted $event)
    {
        $event->user->notify(new InvitationAccepted($event->customer->name));
    }
}
