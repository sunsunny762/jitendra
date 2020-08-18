<?php

namespace App\Listeners;
use App\Events\EmailAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\EmailNotification;
use Illuminate\Notifications\Notifiable;
use App\User;

class EmailActionListener
{
    use Notifiable;
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
    public function handle(EmailAction $event)
    {
        $user = User::find($event->id);
        $user->notify(new EmailNotification($event->password));
    }
}
