<?php

namespace App\Jobs;

use App\Movie;
use App\Services\MailService;
use App\Services\MailServiceImpl;
use App\Services\MovieService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class MovieCreationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $movie;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $mailService;
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
        //$this->mailService = new MailServiceImpl();
    }
    

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MailService $mailService)
    {
        $text = 'A new movie is added to the system. Title: '.$this->movie->title.', description: '.$this->movie->description.', genre: '.$this->movie->load('genre')->genre->name;
        $mailService->sendEmailToAdmins($text);
    }
}
