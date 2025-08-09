<?php

namespace App\Providers;

use App\Console\DbOpenCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use LemonSqueezy\Laravel\LemonSqueezy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        LemonSqueezy::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();

        $this->commands([DbOpenCommand::class]);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
