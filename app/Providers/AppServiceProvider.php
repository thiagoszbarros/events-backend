<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app
            ->when(\App\Http\Controllers\EventController::class)
            ->needs(\App\Interfaces\CRUD::class)
            ->give(\App\Repositories\EventRepository::class);
        $this->app
            ->bind(
                \App\Interfaces\SubscriberRepositoryInterface::class,
                \App\Repositories\SubscriberRepository::class
            );
        $this->app
            ->bind(
                \App\Interfaces\EventsSubscribersInterface::class,
                \App\Repositories\EventsSubscribersRepository::class
            );
    }
}
