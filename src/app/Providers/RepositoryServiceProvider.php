<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository($app->make('App\Models\User'));
        });

        $this->app->singleton(PostRepository::class, function ($app) {
            return new PostRepository($app->make('App\Models\Post'));
        });
    }

    public function boot()
    {
        //
    }
}
