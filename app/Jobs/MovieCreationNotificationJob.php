<?php

namespace App\Jobs;

use App\Movie;
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
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $text = 'A new movie is added to the system. Title: '.$this->movie->title.', description: '.$this->movie->description.', genre: '.$this->movie->load('genre')->genre->name;
        Mail::raw($text,function ($message) {        
            $message->to(env('ADMIN_EMAIL'));
        });
    }
}
