<?php

namespace App\Listeners;

use App\Events\CommunityCreated;
use App\Models\User;
use App\Models\Community;
use App\Notifications\NewCommunity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommunityCreatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommunityCreated $event): void
    {
        foreach (User::whereNot('id', $event->community->user_id)->cursor() as $user) {
            $user->notify(new NewCommunity($event->community));
        }
    }
}
