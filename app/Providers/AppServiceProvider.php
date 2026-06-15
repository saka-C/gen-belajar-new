<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;

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
    // Mengatur agar Guzzle Client tidak mencari file di Laragon
    // Kita buat client yang mengabaikan verifikasi SSL untuk development (aman untuk lokal)
    $client = new Client([
        'verify' => false,
    ]);

    Socialite::extend('google', function ($app) use ($client) {
        $config = $app['config']['services.google'];
        return Socialite::buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, $config)
            ->setHttpClient($client);
    });
}

}
