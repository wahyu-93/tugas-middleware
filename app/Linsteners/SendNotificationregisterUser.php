<?php

namespace App\Linsteners;

use App\Event\EventRegisterUser;
use App\Mail\UserRegisterMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNotificationregisterUser implements ShouldQueue
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
     * @param  EventRegisterUser  $event
     * @return void
     */
    public function handle(EventRegisterUser $event)
    {
        Mail::to($event->user)->send(new UserRegisterMail($event->user));
    }
}
