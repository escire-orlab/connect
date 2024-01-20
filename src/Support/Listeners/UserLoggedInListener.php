<?php

namespace EscireOrlab\Connect\Support\Listeners;

use Illuminate\Auth\Events\Login;

class UserLoggedInListener
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->connect_active = true;
        $user->save();

    }
}
