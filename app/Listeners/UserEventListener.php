<?php

namespace App\Listeners;
use Log;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        Log::info('hola');
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        Log::info('hola');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {   
        $events->listen(
            'App\Events\UserLoggedIn',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'App\Events\UserLoggedOut',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }

}