<?php

namespace App\Listeners;

use App\Events\InvitationAccepted as InvitationAcceptedEvent;
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
    public function handle(InvitationAcceptedEvent $event)
    {
        $event->user->notify(new InvitationAccepted($event->customer->name,$event->user));
    }
}
