<?php

namespace App\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Event::listen(MigrationsEnded::class, function () {

            echo 'Running seeders and news services, please wait...' . PHP_EOL;

            Artisan::call('db:seed');
            Artisan::call('service:news-api');
            Artisan::call('service:ny-times');
            Artisan::call('service:the-guardian');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
