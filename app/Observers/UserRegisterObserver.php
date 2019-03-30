<?php

namespace App\Observers;

use App\Models\UserPending;
use App\Notifications\UserRegisterNotification;
use Notification;

class UserRegisterObserver
{
    /**
     * Handle the user pending "created" event.
     *
     * @param  \App\Models\UserPending $userPending
     * @return void
     */
    public function created(UserPending $userPending)
    {
        if (config('perfectworld.mailactivateuser', true)) {
            Notification::route('mail', $userPending->email)->notify(new UserRegisterNotification($userPending));
        }
    }

    /**
     * Handle the user pending "updated" event.
     *
     * @param  \App\Models\UserPending $userPending
     * @return void
     */
    public function updated(UserPending $userPending)
    {
        //
    }

    /**
     * Handle the user pending "deleted" event.
     *
     * @param  \App\Models\UserPending $userPending
     * @return void
     */
    public function deleted(UserPending $userPending)
    {
        //
    }

    /**
     * Handle the user pending "restored" event.
     *
     * @param  \App\Models\UserPending $userPending
     * @return void
     */
    public function restored(UserPending $userPending)
    {
        //
    }

    /**
     * Handle the user pending "force deleted" event.
     *
     * @param  \App\Models\UserPending $userPending
     * @return void
     */
    public function forceDeleted(UserPending $userPending)
    {
        //
    }
}
