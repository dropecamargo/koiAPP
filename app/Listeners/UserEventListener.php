<?php

namespace App\Listeners;
use App\Models\Base\Empresa;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {

        // Get empresa
        $empresa = Empresa::getEmpresa();
        session([ 'empresa' => $empresa ]);
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {

        // Clean session
        session()->flush();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'auth.login',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'auth.logout',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }
}
