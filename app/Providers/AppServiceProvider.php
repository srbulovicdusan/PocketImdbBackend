<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CommentServiceImpl;
use App\Services\MovieServiceImpl;
use App\Services\WatchItemServiceImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(

            'App\Services\CommentService',
            CommentServiceImpl::class
          );
        $this->app->bind(
            'App\Services\MovieService',
            MovieServiceImpl::class
          );
        $this->app->bind(
            'App\Services\WatchItemService',
            WatchItemServiceImpl::class
          );
        
    }
}
