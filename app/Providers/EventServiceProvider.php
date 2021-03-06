<?php

namespace App\Providers;

use App\Events\InvitationAccepted;
use App\Events\UserInvited;
use App\Listeners\NotifyAcceptedInvitation;
use App\Listeners\SendUserInvitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\LoginToken;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserInvited::class => [
            SendUserInvitation::class
        ],
        InvitationAccepted::class => [
            NotifyAcceptedInvitation::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
