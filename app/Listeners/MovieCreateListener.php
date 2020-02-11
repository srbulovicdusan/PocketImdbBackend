<?php

namespace App\Listeners;

use App\Events\MovieCreated;
use App\Jobs\MovieCreationNotificationJob;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class MovieCreateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    

    /**
     * Handle the event.
     *
     * @param  MovieCreated  $event
     * @return void
     */
    public function handle(MovieCreated $event)
    {
        MovieCreationNotificationJob::dispatch($event->movie);
    }
}
