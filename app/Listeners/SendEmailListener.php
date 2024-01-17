<?php

namespace App\Listeners;

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Jobs\Frontend\SendEmailJob;
use App\Jobs\GlobalSendEmailsJob;
use Exception;
use Illuminate\Support\Facades\Log;

class SendEmailListener
{

    public function onSendingEmail($event)
    {
        try{
            Log::debug('$event->email: ' . print_r($event->email,1));
            dispatch(new GlobalSendEmailsJob($event->viewPath, $event->email));
        } catch(Exception $e){

        }

    }

    /**
     * Handle the event.
     *
     * @param $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            SendEmailEvent::class, 'App\Listeners\SendEmailListener@onSendingEmail'
        );
    }
}
