<?php

namespace App\Listeners;

use App\Events\MovieCreated;
use App\Services\MailService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class MovieCreateNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $mailService;
    public function __construct(MailService $mailService){
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     *
     * @param  MovieCreated  $event
     * @return void
     */
    public function handle(MovieCreated $event)
    {
        
        $text = 'A new movie is added to the system. Title: '.$event->movie->title.', description: '.$event->movie->description.', genre: '.$event->movie->load('genre')->genre->name;
        $this->mailService->sendEmailToAdmins($text);
        
    }
}
